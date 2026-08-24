<?php

namespace App\Models;

use App\Enums\ActivityAction;
use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Notifications\LeadAssigned;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'company',
        'service',
        'message',
        'file_link',
        'status',
        'source',
        'assigned_to',
        'wp_entry_id',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
            'source' => LeadSource::class,
            'submitted_at' => 'datetime',
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class)->latest();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(LeadAttachment::class);
    }

    /**
     * The client record this lead became, once converted.
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Append an entry to the activity log. A null actor means the system did
     * it, which is how webhook-driven entries are recorded.
     */
    public function recordActivity(
        ActivityAction $action,
        ?User $actor = null,
        ?string $note = null,
        array $properties = [],
    ): LeadActivity {
        return $this->activities()->create([
            'user_id' => $actor?->id,
            'action' => $action->value,
            'note' => $note,
            'properties' => $properties ?: null,
        ]);
    }

    /**
     * Move the lead to a new stage, logging the transition. Returns false when
     * the status is unchanged, so no duplicate activity entry is written.
     */
    public function changeStatus(LeadStatus $status, ?User $actor = null): bool
    {
        if ($this->status === $status) {
            return false;
        }

        $from = $this->status;
        $this->status = $status;
        $this->save();

        $this->recordActivity(ActivityAction::StatusChanged, $actor, null, [
            'from' => $from->value,
            'to' => $status->value,
        ]);

        return true;
    }

    /**
     * Assign (or with null, unassign) the lead, logging the change. Returns
     * false when the assignee is unchanged.
     */
    public function assignTo(?User $assignee, ?User $actor = null): bool
    {
        if ($this->assigned_to === $assignee?->id) {
            return false;
        }

        $this->assigned_to = $assignee?->id;
        $this->save();

        if ($assignee) {
            $this->recordActivity(ActivityAction::Assigned, $actor, null, [
                'assigned_to' => $assignee->id,
                'assigned_to_name' => $assignee->name,
            ]);

            // Picking up a lead yourself should not ping you about it.
            if ($assignee->id !== $actor?->id) {
                $assignee->notify(new LeadAssigned($this));
            }
        } else {
            $this->recordActivity(ActivityAction::Unassigned, $actor);
        }

        return true;
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeSource(Builder $query, ?string $source): Builder
    {
        return $source ? $query->where('source', $source) : $query;
    }

    public function scopeAssignedTo(Builder $query, ?string $userId): Builder
    {
        if ($userId === null || $userId === '') {
            return $query;
        }

        return $userId === 'unassigned'
            ? $query->whereNull('assigned_to')
            : $query->where('assigned_to', $userId);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $like = '%'.$term.'%';
            $q->where('name', 'like', $like)
                ->orWhere('email', 'like', $like)
                ->orWhere('company', 'like', $like)
                ->orWhere('website', 'like', $like);
        });
    }
}
