<?php

namespace Tests\Feature;

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use App\Models\LeaveRequest;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffAndLeaveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolePermissionSeeder::class, UserSeeder::class]);
    }

    private function user(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    private function admin(): User
    {
        return $this->user('admin@graphicspixels.test');
    }

    private function teamLeader(): User
    {
        return $this->user('lead1@graphicspixels.test');
    }

    private function editor(): User
    {
        // Seeded reporting to lead1.
        return $this->user('editor1@graphicspixels.test');
    }

    // ------------------------------------------------------------- directory

    public function test_management_can_open_the_staff_directory(): void
    {
        $this->actingAs($this->admin())->get(route('staff.index'))->assertOk();
        $this->actingAs($this->user('production1@graphicspixels.test'))
            ->get(route('staff.index'))->assertOk();
    }

    public function test_editors_cannot_open_the_staff_directory(): void
    {
        $this->actingAs($this->editor())->get(route('staff.index'))->assertForbidden();
    }

    public function test_anyone_can_open_their_own_profile(): void
    {
        $editor = $this->editor();

        $this->actingAs($editor)->get(route('staff.show', $editor))->assertOk();
    }

    public function test_an_editor_cannot_open_somebody_elses_profile(): void
    {
        $this->actingAs($this->editor())
            ->get(route('staff.show', $this->user('editor2@graphicspixels.test')))
            ->assertForbidden();
    }

    public function test_team_leaders_can_see_the_workload_board(): void
    {
        $this->actingAs($this->teamLeader())->get(route('staff.workload'))->assertOk();
        $this->actingAs($this->editor())->get(route('staff.workload'))->assertForbidden();
    }

    public function test_admins_can_reassign_an_editor_to_another_team(): void
    {
        $editor = $this->editor();
        $newLeader = $this->user('lead3@graphicspixels.test');

        $this->actingAs($this->admin())
            ->put(route('staff.update', $editor), [
                'team_leader_id' => $newLeader->id,
                'is_active' => 1,
            ])
            ->assertRedirect();

        $this->assertSame($newLeader->id, $editor->fresh()->team_leader_id);
    }

    public function test_somebody_cannot_be_made_to_report_to_themselves(): void
    {
        $editor = $this->editor();

        $this->actingAs($this->admin())
            ->put(route('staff.update', $editor), ['team_leader_id' => $editor->id])
            ->assertSessionHasErrors('team_leader_id');
    }

    public function test_a_team_leader_cannot_edit_staff_records(): void
    {
        $this->actingAs($this->teamLeader())
            ->put(route('staff.update', $this->editor()), ['job_title' => 'Hacked'])
            ->assertForbidden();
    }

    // ----------------------------------------------------------------- leave

    public function test_anyone_can_request_leave(): void
    {
        $this->actingAs($this->editor())
            ->post(route('leave.store'), [
                'type' => LeaveType::Annual->value,
                'starts_on' => now()->addWeek()->toDateString(),
                'ends_on' => now()->addWeek()->addDays(3)->toDateString(),
                'reason' => 'Family visit.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('leave_requests', [
            'user_id' => $this->editor()->id,
            'status' => LeaveStatus::Pending->value,
        ]);
    }

    public function test_leave_cannot_finish_before_it_starts(): void
    {
        $this->actingAs($this->editor())
            ->post(route('leave.store'), [
                'type' => LeaveType::Annual->value,
                'starts_on' => now()->addWeek()->toDateString(),
                'ends_on' => now()->addDays(2)->toDateString(),
            ])
            ->assertSessionHasErrors('ends_on');
    }

    public function test_overlapping_leave_is_refused(): void
    {
        $editor = $this->editor();

        LeaveRequest::factory()->for($editor)->approved()
            ->between(now()->addWeek()->toDateString(), now()->addWeek()->addDays(4)->toDateString())
            ->create();

        $this->actingAs($editor)
            ->post(route('leave.store'), [
                'type' => LeaveType::Annual->value,
                'starts_on' => now()->addWeek()->addDays(2)->toDateString(),
                'ends_on' => now()->addWeek()->addDays(6)->toDateString(),
            ])
            ->assertSessionHasErrors('starts_on');

        $this->assertSame(1, $editor->leaveRequests()->count());
    }

    public function test_a_team_leader_decides_leave_for_their_own_editor(): void
    {
        $leave = LeaveRequest::factory()->for($this->editor())->create();

        $this->actingAs($this->teamLeader())
            ->patch(route('leave.approve', $leave))
            ->assertRedirect();

        $leave->refresh();

        $this->assertSame(LeaveStatus::Approved, $leave->status);
        $this->assertSame($this->teamLeader()->id, $leave->reviewed_by);
        $this->assertNotNull($leave->reviewed_at);
    }

    public function test_a_team_leader_cannot_decide_for_another_teams_editor(): void
    {
        // editor3 reports to lead2, not lead1.
        $leave = LeaveRequest::factory()->for($this->user('editor3@graphicspixels.test'))->create();

        $this->actingAs($this->teamLeader())
            ->patch(route('leave.approve', $leave))
            ->assertForbidden();
    }

    public function test_nobody_approves_their_own_leave_even_as_admin(): void
    {
        $admin = $this->admin();
        $leave = LeaveRequest::factory()->for($admin)->create();

        $this->actingAs($admin)
            ->patch(route('leave.approve', $leave))
            ->assertForbidden();

        $this->assertSame(LeaveStatus::Pending, $leave->fresh()->status);
    }

    public function test_a_decided_request_cannot_be_decided_again(): void
    {
        $leave = LeaveRequest::factory()->for($this->editor())->approved()->create();

        $this->actingAs($this->admin())
            ->patch(route('leave.deny', $leave))
            ->assertForbidden();
    }

    public function test_an_editor_can_withdraw_their_own_pending_request(): void
    {
        $leave = LeaveRequest::factory()->for($this->editor())->create();

        $this->actingAs($this->editor())
            ->patch(route('leave.cancel', $leave))
            ->assertRedirect();

        $this->assertSame(LeaveStatus::Cancelled, $leave->fresh()->status);
    }

    // ---------------------------------------------------------- availability

    public function test_approved_leave_marks_somebody_unavailable(): void
    {
        $editor = $this->editor();

        LeaveRequest::factory()->for($editor)->approved()->coveringToday()->create();

        $this->assertTrue($editor->fresh()->isOnLeaveOn());
        $this->assertFalse(User::availableOn()->whereKey($editor->id)->exists());
    }

    public function test_pending_leave_does_not_mark_somebody_unavailable(): void
    {
        $editor = $this->editor();

        LeaveRequest::factory()->for($editor)->coveringToday()->create();

        $this->assertFalse($editor->fresh()->isOnLeaveOn());
        $this->assertTrue(User::availableOn()->whereKey($editor->id)->exists());
    }

    public function test_leave_outside_the_day_does_not_affect_availability(): void
    {
        $editor = $this->editor();

        LeaveRequest::factory()->for($editor)->approved()
            ->between(now()->addMonth()->toDateString(), now()->addMonth()->addDays(3)->toDateString())
            ->create();

        $this->assertFalse($editor->fresh()->isOnLeaveOn());
    }

    public function test_auto_assign_skips_editors_on_approved_leave(): void
    {
        $away = $this->editor();

        LeaveRequest::factory()->for($away)->approved()->coveringToday()->create();

        $order = Order::factory()->ledBy($this->teamLeader())->images(60)->create();

        $this->actingAs($this->teamLeader())
            ->post(route('orders.batches.store', $order), [
                'mode' => 'count',
                'batch_count' => 3,
                'auto_assign' => 1,
            ])
            ->assertRedirect();

        $assigned = $order->fresh()->batches->pluck('editor_id');

        $this->assertCount(3, $assigned->filter(), 'Every batch should still find an owner');
        $this->assertFalse(
            $assigned->contains($away->id),
            'An editor on approved leave should not be handed new work',
        );
    }

    // --------------------------------------------------------------- reports

    public function test_reports_are_gated_on_the_reports_permission(): void
    {
        $this->actingAs($this->admin())->get(route('reports.index'))->assertOk();
        $this->actingAs($this->user('production1@graphicspixels.test'))
            ->get(route('reports.index'))->assertOk();

        $this->actingAs($this->editor())->get(route('reports.index'))->assertForbidden();
    }

    public function test_export_requires_the_export_permission(): void
    {
        // Marketing holds reports.view but not reports.export.
        $marketing = $this->user('marketing1@graphicspixels.test');

        $this->actingAs($marketing)->get(route('reports.index'))->assertOk();
        $this->actingAs($marketing)->get(route('reports.export'))->assertForbidden();

        $this->actingAs($this->admin())->get(route('reports.export'))->assertOk();
    }

    public function test_the_order_export_returns_csv(): void
    {
        Order::factory()->count(2)->create();

        $response = $this->actingAs($this->admin())
            ->get(route('reports.export', ['report' => 'orders']))
            ->assertOk();

        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));

        $body = $response->streamedContent();

        $this->assertStringContainsString('Reference', $body);
        $this->assertStringContainsString(Order::first()->reference, $body);
    }
}
