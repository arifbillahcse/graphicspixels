<?php

namespace App\Models;

use App\Enums\BatchStatus;
use App\Enums\OrderStatus;
use App\Enums\QcOutcome;
use App\Enums\QcSeverity;
use App\Support\DefectRate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class QcReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'editor_id',
        'reviewer_id',
        'outcome',
        'checklist',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'outcome' => QcOutcome::class,
            'checklist' => 'array',
            'completed_at' => 'datetime',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * The editor whose work this reviewed, captured when the review opened so
     * reassigning the batch afterwards cannot rewrite anyone's defect figures.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(QcComment::class);
    }

    /**
     * Open a review against a batch that is ready for QC.
     */
    public static function openFor(Batch $batch): self
    {
        return self::create([
            'batch_id' => $batch->id,
            'editor_id' => $batch->editor_id,
            'outcome' => QcOutcome::Pending->value,
        ]);
    }

    /**
     * Pass the batch. Completes the batch, and delivers the order once every
     * batch on it has passed.
     *
     * @param  array<string,bool>  $checklist
     */
    public function approve(User $reviewer, array $checklist = []): void
    {
        DB::transaction(function () use ($reviewer, $checklist) {
            $this->update([
                'reviewer_id' => $reviewer->id,
                'outcome' => QcOutcome::Approved->value,
                'checklist' => $checklist ?: null,
                'completed_at' => now(),
            ]);

            $batch = $this->batch;
            $batch->changeStatus(BatchStatus::Completed, $reviewer);

            $order = $batch->order->refresh();

            $order->addNote("{$batch->label()} passed QC.", $reviewer, $batch);

            // The order is only done when nothing is left outstanding.
            $outstanding = $order->batches()
                ->where('status', '!=', BatchStatus::Completed->value)
                ->count();

            if ($outstanding === 0 && $order->isFullyBatched()) {
                $order->changeStatus(OrderStatus::Delivered, $reviewer);
            } elseif ($order->status === OrderStatus::QcReview) {
                $order->changeStatus(OrderStatus::Editing, $reviewer);
            }

            $this->recordDefectStat(rejected: false);
        });
    }

    /**
     * Fail the batch and send it back to the editor with findings.
     *
     * @param  array<string,bool>  $checklist
     * @param  list<array{comment:string,severity:string}>  $comments
     */
    public function reject(User $reviewer, array $comments, array $checklist = []): void
    {
        DB::transaction(function () use ($reviewer, $comments, $checklist) {
            $this->update([
                'reviewer_id' => $reviewer->id,
                'outcome' => QcOutcome::Rejected->value,
                'checklist' => $checklist ?: null,
                'completed_at' => now(),
            ]);

            foreach ($comments as $entry) {
                $this->comments()->create([
                    'comment' => $entry['comment'],
                    'severity' => $entry['severity'] ?? QcSeverity::Minor->value,
                ]);
            }

            $batch = $this->batch;
            $batch->changeStatus(BatchStatus::Revision, $reviewer);

            $order = $batch->order->refresh();

            $order->addNote(
                sprintf(
                    '%s rejected by QC with %d finding%s.',
                    $batch->label(),
                    count($comments),
                    count($comments) === 1 ? '' : 's',
                ),
                $reviewer,
                $batch,
            );

            if ($order->status !== OrderStatus::Revision) {
                $order->changeStatus(OrderStatus::Revision, $reviewer);
            }

            $this->recordDefectStat(rejected: true);
        });
    }

    private function recordDefectStat(bool $rejected): void
    {
        if ($this->editor_id === null) {
            return;
        }

        DefectStat::record(
            $this->editor_id,
            $rejected,
            DefectRate::period($this->completed_at ?? now()),
        );
    }

    public function blockerCount(): int
    {
        return $this->comments->where('severity', QcSeverity::Blocker)->count();
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('outcome', QcOutcome::Pending->value);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereNotNull('completed_at');
    }
}
