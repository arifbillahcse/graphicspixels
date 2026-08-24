<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\ServiceType;
use App\Notifications\OrderAssigned;
use App\Support\OrderReference;
use App\Support\Sla;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    /**
     * Standard turnaround advertised on the public site.
     */
    public const STANDARD_SLA_HOURS = 24;

    public const RUSH_SLA_HOURS = 6;

    protected $fillable = [
        'reference',
        'client_id',
        'lead_id',
        'service_type',
        'image_count',
        'file_intake_link',
        'delivery_link',
        'status',
        'rush',
        'received_at',
        'deadline',
        'completed_at',
        'risk_at',
        'sla_alerted_at',
        'team_leader_id',
        'created_by',
        'notes',
    ];

    /**
     * Keep the stored at-risk threshold in step with the SLA window.
     */
    protected static function booted(): void
    {
        static::saving(function (self $order) {
            $order->risk_at = $order->calculateRiskAt();

            // A moved deadline is a new promise, so the order earns a fresh
            // at-risk alert rather than staying silent on the old one.
            if ($order->exists && $order->isDirty('deadline')) {
                $order->sla_alerted_at = null;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'service_type' => ServiceType::class,
            'image_count' => 'integer',
            'rush' => 'boolean',
            'received_at' => 'datetime',
            'deadline' => 'datetime',
            'completed_at' => 'datetime',
            'risk_at' => 'datetime',
            'sla_alerted_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function teamLeader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class)->orderBy('batch_number');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(OrderNote::class)->latest();
    }

    // ------------------------------------------------------------------ SLA

    public function sla(): Sla
    {
        return new Sla(
            $this->received_at ?? $this->created_at ?? now(),
            $this->deadline,
            $this->completed_at,
        );
    }

    /**
     * Default deadline for a newly received order.
     */
    public static function defaultDeadline(bool $rush = false, ?DateTimeInterface $from = null): Carbon
    {
        $start = $from ? Carbon::parse($from) : now();

        return $start->copy()->addHours($rush ? self::RUSH_SLA_HOURS : self::STANDARD_SLA_HOURS);
    }

    /**
     * The instant this order reaches 80% of its SLA window.
     */
    public function calculateRiskAt(): ?Carbon
    {
        if ($this->received_at === null || $this->deadline === null) {
            return null;
        }

        $windowMinutes = $this->received_at->diffInMinutes($this->deadline, false);

        if ($windowMinutes <= 0) {
            return $this->deadline;
        }

        return $this->received_at->copy()->addMinutes((int) round($windowMinutes * 0.8));
    }

    // ------------------------------------------------------------ behaviour

    /**
     * Next reference for the current year. Ordering by id rather than by the
     * reference string keeps this correct once the sequence passes 9999 and
     * the zero padding stops sorting lexicographically.
     */
    public static function nextReference(): string
    {
        $year = (int) date('Y');

        $last = self::query()
            ->where('reference', 'like', OrderReference::PREFIX."-{$year}-%")
            ->orderByDesc('id')
            ->value('reference');

        $sequence = $last ? (OrderReference::sequenceOf($last) ?? 0) + 1 : 1;

        return OrderReference::format($sequence, $year);
    }

    /**
     * Move the order through the pipeline, keeping completed_at in step.
     * Returns false when the status is unchanged.
     */
    public function changeStatus(OrderStatus $status, ?User $actor = null): bool
    {
        if ($this->status === $status) {
            return false;
        }

        $from = $this->status;
        $this->status = $status;

        if ($status->isComplete()) {
            $this->completed_at ??= now();
        } else {
            // Reopened, so it is back on the clock.
            $this->completed_at = null;
        }

        $this->save();

        $this->addNote(
            sprintf('Status changed from %s to %s.', $from->label(), $status->label()),
            $actor,
        );

        return true;
    }

    public function assignTeamLeader(?User $leader, ?User $actor = null): bool
    {
        if ($this->team_leader_id === $leader?->id) {
            return false;
        }

        $this->team_leader_id = $leader?->id;

        // Picking up an order moves it out of the unassigned column.
        if ($leader && $this->status === OrderStatus::Received) {
            $this->status = OrderStatus::Assigned;
        }

        $this->save();

        $this->addNote(
            $leader ? "Assigned to {$leader->name}." : 'Team leader removed.',
            $actor,
        );

        if ($leader && $leader->id !== $actor?->id) {
            $leader->notify(new OrderAssigned($this));
        }

        return true;
    }

    public function addNote(string $note, ?User $actor = null, ?Batch $batch = null): OrderNote
    {
        return $this->notes()->create([
            'user_id' => $actor?->id,
            'batch_id' => $batch?->id,
            'note' => $note,
        ]);
    }

    /**
     * Images not yet covered by a batch.
     */
    public function unbatchedImages(): int
    {
        return max(0, $this->image_count - (int) $this->batches()->sum('image_count'));
    }

    public function isFullyBatched(): bool
    {
        return $this->unbatchedImages() === 0 && $this->batches()->exists();
    }

    // --------------------------------------------------------------- scopes

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', '!=', OrderStatus::Delivered->value);
    }

    public function scopeForTeamLeader(Builder $query, int $userId): Builder
    {
        return $query->where('team_leader_id', $userId);
    }

    /**
     * Orders at least 80% through their SLA window and not yet delivered.
     * Reads the stored threshold, so this is an indexed comparison rather
     * than per-row date arithmetic, and behaves the same on SQLite and MySQL.
     */
    public function scopeAtRisk(Builder $query): Builder
    {
        return $query->open()
            ->whereNotNull('risk_at')
            ->where('risk_at', '<=', now());
    }
}
