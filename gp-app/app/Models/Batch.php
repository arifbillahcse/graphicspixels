<?php

namespace App\Models;

use App\Enums\BatchStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'batch_number',
        'image_count',
        'editor_id',
        'status',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => BatchStatus::class,
            'batch_number' => 'integer',
            'image_count' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(OrderNote::class)->latest();
    }

    public function label(): string
    {
        return "Batch {$this->batch_number}";
    }

    /**
     * Move the batch on, stamping the timestamps that go with each stage, and
     * logging the change against the parent order so everything shows up in
     * one timeline. Returns false when the status is unchanged.
     */
    public function changeStatus(BatchStatus $status, ?User $actor = null): bool
    {
        if ($this->status === $status) {
            return false;
        }

        $from = $this->status;
        $this->status = $status;

        if ($status === BatchStatus::InProgress) {
            $this->started_at ??= now();
        }

        if ($status === BatchStatus::Completed) {
            $this->completed_at ??= now();
        } elseif ($this->completed_at !== null) {
            $this->completed_at = null;
        }

        $this->save();

        $this->order->addNote(
            sprintf('%s moved from %s to %s.', $this->label(), $from->label(), $status->label()),
            $actor,
            $this,
        );

        return true;
    }

    public function assignEditor(?User $editor, ?User $actor = null): bool
    {
        if ($this->editor_id === $editor?->id) {
            return false;
        }

        $this->editor_id = $editor?->id;
        $this->save();

        $this->order->addNote(
            $editor ? "{$this->label()} assigned to {$editor->name}." : "{$this->label()} unassigned.",
            $actor,
            $this,
        );

        return true;
    }

    /**
     * Batches still requiring work, used for editor workload balancing.
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereIn('status', [
            BatchStatus::Pending->value,
            BatchStatus::InProgress->value,
            BatchStatus::Revision->value,
        ]);
    }

    public function scopeForEditor(Builder $query, int $editorId): Builder
    {
        return $query->where('editor_id', $editorId);
    }
}
