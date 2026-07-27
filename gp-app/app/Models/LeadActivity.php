<?php

namespace App\Models;

use App\Enums\ActivityAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
        'action',
        'note',
        'properties',
    ];

    protected function casts(): array
    {
        return [
            'action' => ActivityAction::class,
            'properties' => 'array',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Who performed the action, for display in the activity feed.
     */
    public function actorName(): string
    {
        return $this->user?->name ?? 'System';
    }

    /**
     * One-line description of the entry.
     */
    public function summary(): string
    {
        $props = $this->properties ?? [];

        return match ($this->action) {
            ActivityAction::StatusChanged => sprintf(
                'Status changed from %s to %s',
                str_replace('_', ' ', $props['from'] ?? '?'),
                str_replace('_', ' ', $props['to'] ?? '?'),
            ),
            ActivityAction::Assigned => 'Assigned to '.($props['assigned_to_name'] ?? 'someone'),
            default => $this->action->label(),
        };
    }
}
