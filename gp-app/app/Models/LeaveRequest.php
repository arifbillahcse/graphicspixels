<?php

namespace App\Models;

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use App\Support\DateRange;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'starts_on',
        'ends_on',
        'reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_note',
    ];

    protected function casts(): array
    {
        return [
            'type' => LeaveType::class,
            'status' => LeaveStatus::class,
            'starts_on' => 'date',
            'ends_on' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function range(): DateRange
    {
        return new DateRange(
            $this->starts_on->format('Y-m-d'),
            $this->ends_on->format('Y-m-d'),
        );
    }

    public function days(): int
    {
        return $this->range()->days();
    }

    public function approve(User $reviewer, ?string $note = null): void
    {
        $this->update([
            'status' => LeaveStatus::Approved->value,
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
            'review_note' => $note,
        ]);
    }

    public function deny(User $reviewer, ?string $note = null): void
    {
        $this->update([
            'status' => LeaveStatus::Denied->value,
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
            'review_note' => $note,
        ]);
    }

    public function cancel(): void
    {
        $this->update(['status' => LeaveStatus::Cancelled->value]);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', LeaveStatus::Pending->value);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', LeaveStatus::Approved->value);
    }

    /**
     * Requests whose dates touch the given range. Inclusive at both ends, so a
     * single shared day counts.
     */
    public function scopeOverlapping(Builder $query, DateRange $range): Builder
    {
        return $query->where('starts_on', '<=', $range->end)
            ->where('ends_on', '>=', $range->start);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('ends_on', '>=', now()->toDateString());
    }
}
