<?php

namespace App\Enums;

/**
 * Production pipeline for an order, in board order.
 */
enum OrderStatus: string
{
    case Received = 'received';
    case Assigned = 'assigned';
    case Editing = 'editing';
    case QcReview = 'qc_review';
    case Revision = 'revision';
    case Delivered = 'delivered';

    public function label(): string
    {
        return match ($this) {
            self::Received => 'Received',
            self::Assigned => 'Assigned',
            self::Editing => 'Editing',
            self::QcReview => 'QC Review',
            self::Revision => 'Revision',
            self::Delivered => 'Delivered',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Received => 'bg-blue-100 text-blue-800',
            self::Assigned => 'bg-indigo-100 text-indigo-800',
            self::Editing => 'bg-amber-100 text-amber-800',
            self::QcReview => 'bg-purple-100 text-purple-800',
            self::Revision => 'bg-orange-100 text-orange-800',
            self::Delivered => 'bg-green-100 text-green-800',
        };
    }

    /**
     * Delivered orders have left the floor: they stop consuming SLA and drop
     * out of workload counts.
     */
    public function isComplete(): bool
    {
        return $this === self::Delivered;
    }

    /**
     * An order must have a team leader before work can start.
     */
    public function requiresTeamLeader(): bool
    {
        return ! in_array($this, [self::Received, self::Delivered], true);
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $s) => $s->value, self::cases());
    }
}
