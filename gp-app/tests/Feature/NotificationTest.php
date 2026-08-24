<?php

namespace Tests\Feature;

use App\Enums\LeadStatus;
use App\Enums\QcSeverity;
use App\Models\Batch;
use App\Models\Lead;
use App\Models\LeaveRequest;
use App\Models\NotificationPreference;
use App\Models\Order;
use App\Models\QcReview;
use App\Models\User;
use App\Notifications\BatchAssigned;
use App\Notifications\BatchRejected;
use App\Notifications\LeadAssigned;
use App\Notifications\LeaveDecided;
use App\Notifications\OrderAssigned;
use App\Notifications\OrderAtRisk;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
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

    private function marketing(): User
    {
        return $this->user('marketing1@graphicspixels.test');
    }

    private function teamLeader(): User
    {
        return $this->user('lead1@graphicspixels.test');
    }

    private function editor(): User
    {
        return $this->user('editor1@graphicspixels.test');
    }

    private function qc(): User
    {
        return $this->user('qc1@graphicspixels.test');
    }

    // ------------------------------------------------------------- dispatch

    public function test_assigning_a_lead_notifies_the_new_owner(): void
    {
        Notification::fake();

        $lead = Lead::factory()->create();
        $owner = $this->user('marketing2@graphicspixels.test');

        $lead->assignTo($owner, $this->marketing());

        Notification::assertSentTo($owner, LeadAssigned::class);
    }

    public function test_taking_a_lead_yourself_does_not_notify_you(): void
    {
        Notification::fake();

        $lead = Lead::factory()->create();
        $me = $this->marketing();

        $lead->assignTo($me, $me);

        Notification::assertNothingSent();
    }

    public function test_assigning_an_order_notifies_the_team_leader(): void
    {
        Notification::fake();

        $order = Order::factory()->create();
        $leader = $this->teamLeader();

        $order->assignTeamLeader($leader, $this->user('production1@graphicspixels.test'));

        Notification::assertSentTo($leader, OrderAssigned::class);
    }

    public function test_assigning_a_batch_notifies_the_editor(): void
    {
        Notification::fake();

        $batch = Batch::factory()->create();
        $editor = $this->editor();

        $batch->assignEditor($editor, $this->teamLeader());

        Notification::assertSentTo($editor, BatchAssigned::class);
    }

    public function test_a_qc_rejection_notifies_the_editor(): void
    {
        Notification::fake();

        $batch = Batch::factory()->editedBy($this->editor())->create();
        $review = QcReview::openFor($batch);

        $review->reject($this->qc(), [
            ['comment' => 'Halos on the left edge.', 'severity' => QcSeverity::Blocker->value],
        ]);

        Notification::assertSentTo($this->editor(), BatchRejected::class);
    }

    public function test_deciding_leave_notifies_the_person_who_asked(): void
    {
        Notification::fake();

        $editor = $this->editor();
        $leave = LeaveRequest::factory()->for($editor)->create();

        $leave->approve($this->teamLeader());

        Notification::assertSentTo($editor, LeaveDecided::class);
    }

    public function test_converting_a_lead_tells_production(): void
    {
        Notification::fake();

        $lead = Lead::factory()->create(['status' => LeadStatus::Negotiating->value]);

        $this->actingAs($this->marketing())
            ->post(route('leads.convert.store', $lead), [
                'service_type' => \App\Enums\ServiceType::ClippingPath->value,
                'image_count' => 100,
                'deadline' => now()->addDay()->format('Y-m-d H:i:s'),
                'rate_tier' => 'standard',
            ]);

        Notification::assertSentTo(
            $this->user('production1@graphicspixels.test'),
            \App\Notifications\OrderCreated::class,
        );
    }

    // ---------------------------------------------------------- preferences

    public function test_a_notification_is_stored_in_app_by_default(): void
    {
        Mail::fake();

        $batch = Batch::factory()->create();
        $editor = $this->editor();

        $batch->assignEditor($editor, $this->teamLeader());

        $this->assertSame(1, $editor->fresh()->notifications()->count());
    }

    public function test_opting_out_of_in_app_stops_it_being_stored(): void
    {
        Mail::fake();

        $editor = $this->editor();

        NotificationPreference::create([
            'user_id' => $editor->id,
            'notification_key' => 'batch.assigned',
            'email' => false,
            'in_app' => false,
        ]);

        Batch::factory()->create()->assignEditor($editor->fresh(), $this->teamLeader());

        $this->assertSame(0, $editor->fresh()->notifications()->count());
    }

    public function test_opting_out_of_one_type_leaves_the_others_alone(): void
    {
        Mail::fake();

        $editor = $this->editor();

        NotificationPreference::create([
            'user_id' => $editor->id,
            'notification_key' => 'batch.assigned',
            'email' => false,
            'in_app' => false,
        ]);

        // A different type, still on by default.
        $batch = Batch::factory()->editedBy($editor)->create();
        QcReview::openFor($batch)->reject($this->qc(), [
            ['comment' => 'Rough edges.', 'severity' => QcSeverity::Minor->value],
        ]);

        $this->assertSame(1, $editor->fresh()->notifications()->count());
    }

    public function test_preferences_can_be_saved_from_the_settings_screen(): void
    {
        $editor = $this->editor();

        $this->actingAs($editor)
            ->put(route('notifications.preferences.update'), [
                'in_app' => ['batch.assigned'],
                'email' => ['batch.assigned', 'batch.rejected'],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('notification_preferences', [
            'user_id' => $editor->id,
            'notification_key' => 'batch.assigned',
            'email' => true,
            'in_app' => true,
        ]);

        // Unticked boxes must persist as an explicit no.
        $this->assertDatabaseHas('notification_preferences', [
            'user_id' => $editor->id,
            'notification_key' => 'batch.rejected',
            'email' => true,
            'in_app' => false,
        ]);
    }

    // ------------------------------------------------------------- the centre

    public function test_the_centre_shows_only_your_own_notifications(): void
    {
        Mail::fake();

        $mine = $this->editor();
        $theirs = $this->user('editor2@graphicspixels.test');

        Batch::factory()->create()->assignEditor($mine, $this->teamLeader());
        Batch::factory()->number(2)->create()->assignEditor($theirs, $this->teamLeader());

        $this->assertSame(1, $mine->fresh()->notifications()->count());

        $this->actingAs($mine)->get(route('notifications.index'))->assertOk();
    }

    public function test_reading_a_notification_marks_it_and_follows_the_link(): void
    {
        Mail::fake();

        $editor = $this->editor();
        Batch::factory()->create()->assignEditor($editor, $this->teamLeader());

        $notification = $editor->fresh()->notifications()->sole();

        $this->actingAs($editor)
            ->get(route('notifications.read', $notification->id))
            ->assertRedirect(route('batches.mine'));

        $this->assertNotNull($editor->fresh()->notifications()->sole()->read_at);
    }

    public function test_you_cannot_read_somebody_elses_notification(): void
    {
        Mail::fake();

        $theirs = $this->user('editor2@graphicspixels.test');
        Batch::factory()->create()->assignEditor($theirs, $this->teamLeader());

        $notification = $theirs->fresh()->notifications()->sole();

        $this->actingAs($this->editor())
            ->get(route('notifications.read', $notification->id))
            ->assertNotFound();
    }

    public function test_mark_all_read_clears_the_badge(): void
    {
        Mail::fake();

        $editor = $this->editor();
        Batch::factory()->create()->assignEditor($editor, $this->teamLeader());
        Batch::factory()->number(2)->create()->assignEditor($editor->fresh(), $this->teamLeader());

        $this->assertSame(2, $editor->fresh()->unreadNotifications()->count());

        $this->actingAs($editor)->post(route('notifications.read-all'))->assertRedirect();

        $this->assertSame(0, $editor->fresh()->unreadNotifications()->count());
    }

    // --------------------------------------------------------- the SLA check

    public function test_the_sla_command_alerts_on_an_at_risk_order(): void
    {
        Notification::fake();

        Order::factory()->dueInMinutes(30)->ledBy($this->teamLeader())->create();

        $this->artisan('orders:check-sla')->assertExitCode(0);

        Notification::assertSentTo($this->user('production1@graphicspixels.test'), OrderAtRisk::class);
        Notification::assertSentTo($this->teamLeader(), OrderAtRisk::class);
    }

    public function test_the_sla_command_does_not_alert_twice_on_the_same_order(): void
    {
        Notification::fake();

        $order = Order::factory()->dueInMinutes(30)->create();

        $this->artisan('orders:check-sla');
        $this->assertNotNull($order->fresh()->sla_alerted_at);

        Notification::fake();
        $this->artisan('orders:check-sla');

        Notification::assertNothingSent();
    }

    public function test_moving_the_deadline_earns_a_fresh_alert(): void
    {
        Notification::fake();

        $order = Order::factory()->dueInMinutes(30)->create();
        $this->artisan('orders:check-sla');

        // Renegotiated: a new promise deserves a new warning if it slips again.
        $order->update(['deadline' => now()->addMinutes(20)]);

        $this->assertNull($order->fresh()->sla_alerted_at);
    }

    public function test_a_healthy_order_is_not_alerted(): void
    {
        Notification::fake();

        Order::factory()->create();

        $this->artisan('orders:check-sla')->assertExitCode(0);

        Notification::assertNothingSent();
    }

    public function test_the_dry_run_sends_nothing_and_leaves_no_marker(): void
    {
        Notification::fake();

        $order = Order::factory()->dueInMinutes(30)->create();

        $this->artisan('orders:check-sla', ['--dry-run' => true])->assertExitCode(0);

        Notification::assertNothingSent();
        $this->assertNull($order->fresh()->sla_alerted_at);
    }
}
