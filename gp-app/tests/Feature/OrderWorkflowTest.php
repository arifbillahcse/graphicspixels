<?php

namespace Tests\Feature;

use App\Enums\BatchStatus;
use App\Enums\LeadStatus;
use App\Enums\OrderStatus;
use App\Enums\RoleName;
use App\Enums\ServiceType;
use App\Models\Batch;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Order;
use App\Models\User;
use App\Support\Sla;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderWorkflowTest extends TestCase
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

    private function productionManager(): User
    {
        return $this->user('production1@graphicspixels.test');
    }

    private function teamLeader(): User
    {
        return $this->user('lead1@graphicspixels.test');
    }

    private function editor(): User
    {
        return $this->user('editor1@graphicspixels.test');
    }

    // ------------------------------------------------------------ conversion

    public function test_converting_a_lead_creates_a_client_and_an_order(): void
    {
        $lead = Lead::factory()->create([
            'email' => 'buyer@shop.test',
            'name' => 'Buyer',
        ]);

        $deadline = now()->addHours(24)->startOfMinute();

        $this->actingAs($this->marketing())
            ->post(route('leads.convert.store', $lead), [
                'service_type' => ServiceType::ClippingPath->value,
                'image_count' => 500,
                'deadline' => $deadline->format('Y-m-d H:i:s'),
                'rate_tier' => 'standard',
            ])
            ->assertRedirect();

        $order = Order::sole();

        $this->assertSame(500, $order->image_count);
        $this->assertSame(ServiceType::ClippingPath, $order->service_type);
        $this->assertSame(OrderStatus::Received, $order->status);
        $this->assertSame($deadline->timestamp, $order->deadline->timestamp);
        $this->assertMatchesRegularExpression('/^GP-\d{4}-\d{4}$/', $order->reference);

        $client = Client::sole();
        $this->assertSame('buyer@shop.test', $client->email);
        $this->assertSame($client->id, $order->client_id);

        $this->assertSame(LeadStatus::Converted, $lead->fresh()->status);
    }

    public function test_converting_a_returning_client_reuses_their_record(): void
    {
        $client = Client::factory()->create(['email' => 'repeat@shop.test']);
        $lead = Lead::factory()->create(['email' => 'repeat@shop.test']);

        $this->actingAs($this->marketing())
            ->post(route('leads.convert.store', $lead), [
                'service_type' => ServiceType::PhotoRetouching->value,
                'image_count' => 20,
                'deadline' => now()->addDay()->format('Y-m-d H:i:s'),
                'rate_tier' => 'standard',
            ]);

        $this->assertDatabaseCount('clients', 1);
        $this->assertSame($client->id, Order::sole()->client_id);
    }

    public function test_an_editor_cannot_convert_a_lead(): void
    {
        $lead = Lead::factory()->create();

        $this->actingAs($this->editor())
            ->get(route('leads.convert', $lead))
            ->assertForbidden();
    }

    // ----------------------------------------------------------------- board

    public function test_production_staff_can_see_the_board_but_editors_cannot(): void
    {
        $this->actingAs($this->productionManager())->get(route('orders.index'))->assertOk();
        $this->actingAs($this->teamLeader())->get(route('orders.index'))->assertOk();

        // Editors would otherwise see every client's work.
        $this->actingAs($this->editor())->get(route('orders.index'))->assertForbidden();
        $this->actingAs($this->user('qc1@graphicspixels.test'))->get(route('orders.index'))->assertForbidden();
    }

    public function test_an_order_moves_between_columns(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->create();

        $this->actingAs($this->productionManager())
            ->patch(route('orders.status', $order), ['status' => OrderStatus::Editing->value])
            ->assertRedirect();

        $this->assertSame(OrderStatus::Editing, $order->fresh()->status);
    }

    public function test_the_board_answers_json_for_drag_and_drop(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->create();

        $this->actingAs($this->productionManager())
            ->patchJson(route('orders.status', $order), ['status' => OrderStatus::QcReview->value])
            ->assertOk()
            ->assertJson(['ok' => true, 'status' => OrderStatus::QcReview->value]);
    }

    public function test_an_order_cannot_leave_received_without_a_team_leader(): void
    {
        $order = Order::factory()->create();

        $this->actingAs($this->productionManager())
            ->patchJson(route('orders.status', $order), ['status' => OrderStatus::Editing->value])
            ->assertStatus(422)
            ->assertJson(['ok' => false]);

        $this->assertSame(OrderStatus::Received, $order->fresh()->status);
    }

    public function test_assigning_a_team_leader_moves_the_order_out_of_received(): void
    {
        $order = Order::factory()->create();
        $leader = $this->teamLeader();

        $this->actingAs($this->productionManager())
            ->patch(route('orders.assign', $order), ['team_leader_id' => $leader->id])
            ->assertRedirect();

        $order->refresh();

        $this->assertSame($leader->id, $order->team_leader_id);
        $this->assertSame(OrderStatus::Assigned, $order->status);
    }

    public function test_a_team_leader_can_drive_their_own_order_but_not_another(): void
    {
        $mine = Order::factory()->ledBy($this->teamLeader())->create();
        $theirs = Order::factory()->ledBy($this->user('lead2@graphicspixels.test'))->create();

        // Team leaders hold orders.view but not orders.update; ownership is
        // what lets them act.
        $this->actingAs($this->teamLeader())
            ->patch(route('orders.status', $mine), ['status' => OrderStatus::Editing->value])
            ->assertRedirect();

        $this->assertSame(OrderStatus::Editing, $mine->fresh()->status);

        $this->actingAs($this->teamLeader())
            ->patch(route('orders.status', $theirs), ['status' => OrderStatus::Editing->value])
            ->assertForbidden();

        $this->assertSame(OrderStatus::Assigned, $theirs->fresh()->status);
    }

    public function test_delivering_an_order_stamps_completed_at(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->create();

        $this->actingAs($this->productionManager())
            ->patch(route('orders.status', $order), ['status' => OrderStatus::Delivered->value]);

        $this->assertNotNull($order->fresh()->completed_at);
    }

    // --------------------------------------------------------------- batches

    public function test_a_team_leader_splits_an_order_into_batches(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->images(100)->create();

        $this->actingAs($this->teamLeader())
            ->post(route('orders.batches.store', $order), [
                'mode' => 'count',
                'batch_count' => 2,
                'auto_assign' => 1,
            ])
            ->assertRedirect();

        $batches = $order->fresh()->batches;

        $this->assertCount(2, $batches);
        $this->assertSame(100, $batches->sum('image_count'));
        $this->assertSame([1, 2], $batches->pluck('batch_number')->all());

        // Auto-assign spreads work, so two batches land on two editors.
        $this->assertCount(2, $batches->pluck('editor_id')->unique()->filter());
    }

    public function test_splitting_by_size_produces_a_smaller_final_batch(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->images(10)->create();

        $this->actingAs($this->teamLeader())
            ->post(route('orders.batches.store', $order), [
                'mode' => 'size',
                'batch_size' => 3,
            ]);

        $this->assertSame([3, 3, 3, 1], $order->fresh()->batches->pluck('image_count')->all());
    }

    public function test_splitting_moves_the_order_into_editing(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->images(50)->create();

        $this->actingAs($this->teamLeader())
            ->post(route('orders.batches.store', $order), ['mode' => 'count', 'batch_count' => 2]);

        $this->assertSame(OrderStatus::Editing, $order->fresh()->status);
    }

    public function test_an_order_cannot_be_over_batched(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->images(10)->create();

        $this->actingAs($this->teamLeader())
            ->post(route('orders.batches.store', $order), ['mode' => 'count', 'batch_count' => 2]);

        $this->actingAs($this->teamLeader())
            ->post(route('orders.batches.store', $order), ['mode' => 'count', 'batch_count' => 2])
            ->assertSessionHasErrors('mode');

        $this->assertSame(10, $order->fresh()->batches->sum('image_count'));
    }

    public function test_an_editor_cannot_split_an_order(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->create();

        $this->actingAs($this->editor())
            ->post(route('orders.batches.store', $order), ['mode' => 'count', 'batch_count' => 2])
            ->assertForbidden();
    }

    // ---------------------------------------------------------- editor view

    public function test_an_editor_sees_only_their_own_batches(): void
    {
        $order = Order::factory()->ledBy($this->teamLeader())->create();

        $mine = Batch::factory()->number(1)->editedBy($this->editor())->create(['order_id' => $order->id]);
        $theirs = Batch::factory()->number(2)->editedBy($this->user('editor2@graphicspixels.test'))
            ->create(['order_id' => $order->id]);

        $response = $this->actingAs($this->editor())->get(route('batches.mine'))->assertOk();

        $response->assertSee($mine->label());
        $response->assertDontSee('Batch '.$theirs->batch_number);
    }

    public function test_an_editor_progresses_their_own_batch(): void
    {
        $batch = Batch::factory()->editedBy($this->editor())->create();

        $this->actingAs($this->editor())
            ->patch(route('batches.status', $batch), ['status' => BatchStatus::InProgress->value])
            ->assertRedirect();

        $batch->refresh();

        $this->assertSame(BatchStatus::InProgress, $batch->status);
        $this->assertNotNull($batch->started_at);
    }

    public function test_an_editor_cannot_skip_qc(): void
    {
        $batch = Batch::factory()->editedBy($this->editor())->create();

        // Pending may only become In Progress; Completed is QC's call.
        $this->actingAs($this->editor())
            ->patch(route('batches.status', $batch), ['status' => BatchStatus::Completed->value])
            ->assertSessionHasErrors('status');

        $this->assertSame(BatchStatus::Pending, $batch->fresh()->status);
    }

    public function test_an_editor_cannot_touch_another_editors_batch(): void
    {
        $batch = Batch::factory()->editedBy($this->user('editor2@graphicspixels.test'))->create();

        $this->actingAs($this->editor())
            ->patch(route('batches.status', $batch), ['status' => BatchStatus::InProgress->value])
            ->assertForbidden();
    }

    public function test_a_manager_may_set_any_batch_status(): void
    {
        $batch = Batch::factory()->editedBy($this->editor())->create();

        $this->actingAs($this->productionManager())
            ->patch(route('batches.status', $batch), ['status' => BatchStatus::Completed->value])
            ->assertRedirect();

        $this->assertSame(BatchStatus::Completed, $batch->fresh()->status);
    }

    // ------------------------------------------------------------------- SLA

    public function test_an_order_due_within_four_hours_is_critical(): void
    {
        $order = Order::factory()->dueInMinutes(30)->create();

        $this->assertSame(Sla::RISK_CRITICAL, $order->sla()->risk());
        $this->assertTrue($order->sla()->isAtRisk());
    }

    public function test_a_fresh_order_is_not_at_risk(): void
    {
        $order = Order::factory()->create();

        $this->assertSame(Sla::RISK_OK, $order->sla()->risk());
        $this->assertFalse($order->sla()->isAtRisk());
    }

    public function test_an_overdue_order_is_breached(): void
    {
        $order = Order::factory()->dueInMinutes(-60)->create();

        $this->assertSame(Sla::RISK_BREACHED, $order->sla()->risk());
        $this->assertTrue($order->sla()->isBreached());
    }

    public function test_the_at_risk_scope_finds_only_orders_past_eighty_percent(): void
    {
        $atRisk = Order::factory()->dueInMinutes(30)->create();
        Order::factory()->create();
        Order::factory()->dueInMinutes(30)->status(OrderStatus::Delivered)->create();

        $found = Order::atRisk()->get();

        $this->assertCount(1, $found, 'Only the open, nearly-due order should be at risk');
        $this->assertSame($atRisk->id, $found->first()->id);
    }

    public function test_risk_at_is_recalculated_when_the_deadline_moves(): void
    {
        $order = Order::factory()->create();
        $originalRiskAt = $order->risk_at;

        $order->update(['deadline' => $order->deadline->copy()->addHours(48)]);

        $this->assertTrue(
            $order->fresh()->risk_at->greaterThan($originalRiskAt),
            'Extending the deadline should push the at-risk threshold out',
        );
    }
}
