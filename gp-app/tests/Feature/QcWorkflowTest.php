<?php

namespace Tests\Feature;

use App\Enums\BatchStatus;
use App\Enums\OrderStatus;
use App\Enums\QcOutcome;
use App\Enums\QcSeverity;
use App\Enums\ServiceType;
use App\Models\Batch;
use App\Models\DefectStat;
use App\Models\Order;
use App\Models\QcReview;
use App\Models\User;
use App\Support\DefectRate;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QcWorkflowTest extends TestCase
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

    private function qc(): User
    {
        return $this->user('qc1@graphicspixels.test');
    }

    private function editor(): User
    {
        return $this->user('editor1@graphicspixels.test');
    }

    /**
     * A batch sitting in the QC queue, on an order that is fully batched.
     */
    private function batchReadyForQc(int $images = 100): Batch
    {
        $order = Order::factory()
            ->ledBy($this->user('lead1@graphicspixels.test'))
            ->images($images)
            ->status(OrderStatus::QcReview)
            ->create(['service_type' => ServiceType::ClippingPath->value]);

        return Batch::factory()
            ->number(1)
            ->editedBy($this->editor())
            ->status(BatchStatus::ReadyForQc)
            ->create(['order_id' => $order->id, 'image_count' => $images]);
    }

    private function openReview(Batch $batch): QcReview
    {
        return QcReview::openFor($batch);
    }

    // ---------------------------------------------------------------- access

    public function test_qc_staff_can_open_the_queue(): void
    {
        $this->actingAs($this->qc())->get(route('qc.queue'))->assertOk();
    }

    public function test_editors_and_marketing_cannot_open_the_queue(): void
    {
        $this->actingAs($this->editor())->get(route('qc.queue'))->assertForbidden();

        $this->actingAs($this->user('marketing1@graphicspixels.test'))
            ->get(route('qc.queue'))
            ->assertForbidden();
    }

    public function test_a_production_manager_cannot_sign_off_work(): void
    {
        // qc.approve and qc.reject sit outside the production chain on purpose.
        $review = $this->openReview($this->batchReadyForQc());

        $this->actingAs($this->user('production1@graphicspixels.test'))
            ->post(route('qc.approve', $review))
            ->assertForbidden();
    }

    public function test_the_queue_lists_only_batches_ready_for_review(): void
    {
        $ready = $this->batchReadyForQc();
        Batch::factory()->status(BatchStatus::InProgress)->create();

        $response = $this->actingAs($this->qc())->get(route('qc.queue'))->assertOk();

        $response->assertSee($ready->order->reference);
        $this->assertCount(1, Batch::where('status', BatchStatus::ReadyForQc->value)->get());
    }

    // --------------------------------------------------------------- approve

    public function test_approving_completes_the_batch_and_delivers_the_order(): void
    {
        $batch = $this->batchReadyForQc();
        $review = $this->openReview($batch);

        $this->actingAs($this->qc())
            ->post(route('qc.approve', $review), [
                'checklist' => ['Edges clean and precise', 'No halos or white fringing'],
            ])
            ->assertRedirect(route('qc.queue'));

        $this->assertSame(BatchStatus::Completed, $batch->fresh()->status);

        // Every batch on the order passed, so the order is done.
        $order = $batch->order->fresh();
        $this->assertSame(OrderStatus::Delivered, $order->status);
        $this->assertNotNull($order->completed_at);

        $review->refresh();
        $this->assertSame(QcOutcome::Approved, $review->outcome);
        $this->assertNotNull($review->completed_at);
        $this->assertSame($this->qc()->id, $review->reviewer_id);
    }

    public function test_the_checklist_is_recorded_as_answered_and_unanswered(): void
    {
        $review = $this->openReview($this->batchReadyForQc());

        $this->actingAs($this->qc())
            ->post(route('qc.approve', $review), [
                'checklist' => ['Edges clean and precise'],
            ]);

        $checklist = $review->fresh()->checklist;

        $this->assertTrue($checklist['Edges clean and precise']);
        $this->assertFalse($checklist['No halos or white fringing']);
        $this->assertCount(5, $checklist, 'Every clipping-path check should be recorded');
    }

    public function test_an_order_is_not_delivered_while_a_sibling_batch_is_outstanding(): void
    {
        $batch = $this->batchReadyForQc(100);
        $batch->update(['image_count' => 50]);

        // A second batch on the same order is still being worked on.
        Batch::factory()->number(2)->status(BatchStatus::InProgress)
            ->create(['order_id' => $batch->order_id, 'image_count' => 50]);

        $review = $this->openReview($batch);

        $this->actingAs($this->qc())->post(route('qc.approve', $review));

        $this->assertSame(BatchStatus::Completed, $batch->fresh()->status);
        $this->assertNotSame(OrderStatus::Delivered, $batch->order->fresh()->status);
    }

    // ---------------------------------------------------------------- reject

    public function test_rejecting_sends_the_batch_back_with_findings(): void
    {
        $batch = $this->batchReadyForQc();
        $review = $this->openReview($batch);

        $this->actingAs($this->qc())
            ->post(route('qc.reject', $review), [
                'comments' => [
                    ['comment' => 'Halos visible on the left edge.', 'severity' => QcSeverity::Blocker->value],
                    ['comment' => 'Path is slightly loose at the handle.', 'severity' => QcSeverity::Minor->value],
                ],
            ])
            ->assertRedirect(route('qc.queue'));

        $this->assertSame(BatchStatus::Revision, $batch->fresh()->status);
        $this->assertSame(OrderStatus::Revision, $batch->order->fresh()->status);

        $review->refresh();
        $this->assertSame(QcOutcome::Rejected, $review->outcome);
        $this->assertCount(2, $review->comments);
        $this->assertSame(1, $review->blockerCount());
    }

    public function test_a_rejection_needs_at_least_one_finding(): void
    {
        $batch = $this->batchReadyForQc();
        $review = $this->openReview($batch);

        $this->actingAs($this->qc())
            ->post(route('qc.reject', $review), ['comments' => []])
            ->assertSessionHasErrors('comments');

        $this->assertSame(BatchStatus::ReadyForQc, $batch->fresh()->status);
    }

    public function test_blank_rows_in_the_findings_form_are_ignored(): void
    {
        $batch = $this->batchReadyForQc();
        $review = $this->openReview($batch);

        $this->actingAs($this->qc())
            ->post(route('qc.reject', $review), [
                'comments' => [
                    ['comment' => 'Edges are rough.', 'severity' => QcSeverity::Blocker->value],
                    ['comment' => '   ', 'severity' => QcSeverity::Minor->value],
                    ['comment' => '', 'severity' => QcSeverity::Minor->value],
                ],
            ]);

        $this->assertCount(1, $review->fresh()->comments);
    }

    public function test_a_completed_review_cannot_be_decided_twice(): void
    {
        $review = $this->openReview($this->batchReadyForQc());

        $this->actingAs($this->qc())->post(route('qc.approve', $review));

        $this->actingAs($this->qc())
            ->post(route('qc.approve', $review))
            ->assertForbidden();
    }

    // ------------------------------------------------------------ full cycle

    public function test_the_rejection_loop_runs_until_the_batch_passes(): void
    {
        $batch = $this->batchReadyForQc();

        // First pass: rejected.
        $first = $this->openReview($batch);
        $this->actingAs($this->qc())->post(route('qc.reject', $first), [
            'comments' => [['comment' => 'Halos.', 'severity' => QcSeverity::Blocker->value]],
        ]);

        $this->assertSame(BatchStatus::Revision, $batch->fresh()->status);

        // The editor reworks it and sends it back.
        $this->actingAs($this->editor())
            ->patch(route('batches.status', $batch), ['status' => BatchStatus::InProgress->value]);
        $this->actingAs($this->editor())
            ->patch(route('batches.status', $batch), ['status' => BatchStatus::ReadyForQc->value]);

        $this->assertSame(BatchStatus::ReadyForQc, $batch->fresh()->status);

        // Second pass: approved.
        $second = $this->openReview($batch->fresh());
        $this->actingAs($this->qc())->post(route('qc.approve', $second));

        $this->assertSame(BatchStatus::Completed, $batch->fresh()->status);
        $this->assertSame(OrderStatus::Delivered, $batch->order->fresh()->status);

        $this->assertSame(2, QcReview::where('batch_id', $batch->id)->completed()->count());
    }

    // -------------------------------------------------------- defect figures

    public function test_a_rejection_is_recorded_against_the_editor(): void
    {
        $review = $this->openReview($this->batchReadyForQc());

        $this->actingAs($this->qc())->post(route('qc.reject', $review), [
            'comments' => [['comment' => 'Halos.', 'severity' => QcSeverity::Blocker->value]],
        ]);

        $stat = DefectStat::where('editor_id', $this->editor()->id)
            ->where('period', DefectRate::period())
            ->sole();

        $this->assertSame(1, $stat->total_reviews);
        $this->assertSame(1, $stat->rejected_count);
        $this->assertSame(100.0, $stat->reject_rate);
    }

    public function test_an_approval_counts_towards_the_total_but_not_the_rejections(): void
    {
        $review = $this->openReview($this->batchReadyForQc());

        $this->actingAs($this->qc())->post(route('qc.approve', $review));

        $stat = DefectStat::where('editor_id', $this->editor()->id)->sole();

        $this->assertSame(1, $stat->total_reviews);
        $this->assertSame(0, $stat->rejected_count);
        $this->assertSame(0.0, $stat->reject_rate);
    }

    public function test_the_rate_accumulates_across_reviews(): void
    {
        $editorId = $this->editor()->id;

        // Four reviews, one of them rejected: 25%.
        foreach ([true, false, false, false] as $rejected) {
            DefectStat::record($editorId, $rejected);
        }

        $stat = DefectStat::where('editor_id', $editorId)->sole();

        $this->assertSame(4, $stat->total_reviews);
        $this->assertSame(1, $stat->rejected_count);
        $this->assertSame(25.0, $stat->reject_rate);
    }

    public function test_the_editor_is_pinned_when_the_review_opens(): void
    {
        $batch = $this->batchReadyForQc();
        $original = $this->editor();
        $review = $this->openReview($batch);

        // Reassigning the batch afterwards must not move the mark.
        $batch->update(['editor_id' => $this->user('editor2@graphicspixels.test')->id]);

        $this->actingAs($this->qc())->post(route('qc.reject', $review), [
            'comments' => [['comment' => 'Halos.', 'severity' => QcSeverity::Blocker->value]],
        ]);

        $this->assertSame($original->id, $review->fresh()->editor_id);
        $this->assertDatabaseHas('defect_stats', ['editor_id' => $original->id, 'rejected_count' => 1]);
        $this->assertDatabaseMissing('defect_stats', [
            'editor_id' => $this->user('editor2@graphicspixels.test')->id,
        ]);
    }

    public function test_qc_staff_can_see_the_defect_table(): void
    {
        $this->actingAs($this->qc())->get(route('qc.defects'))->assertOk();
    }

    public function test_editors_cannot_see_the_defect_table(): void
    {
        $this->actingAs($this->editor())->get(route('qc.defects'))->assertForbidden();
    }

    public function test_rebuilding_a_period_matches_the_running_totals(): void
    {
        $batch = $this->batchReadyForQc();
        $review = $this->openReview($batch);

        $this->actingAs($this->qc())->post(route('qc.reject', $review), [
            'comments' => [['comment' => 'Halos.', 'severity' => QcSeverity::Blocker->value]],
        ]);

        // Corrupt the running total, then repair it from the reviews.
        DefectStat::query()->update(['total_reviews' => 99, 'rejected_count' => 99, 'reject_rate' => 99]);

        DefectStat::rebuildFor(DefectRate::period());

        $stat = DefectStat::where('editor_id', $this->editor()->id)->sole();

        $this->assertSame(1, $stat->total_reviews);
        $this->assertSame(1, $stat->rejected_count);
    }
}
