<?php

namespace App\Enums;

enum LeaveStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Denied = 'denied';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Denied => 'Denied',
            self::Cancelled => 'Cancelled',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-100 text-amber-800',
            self::Approved => 'bg-green-100 text-green-800',
            self::Denied => 'bg-red-100 text-red-800',
            self::Cancelled => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Only approved leave takes someone out of the assignment pool. A pending
     * request must not quietly stop work being given to them.
     */
    public function blocksAvailability(): bool
    {
        return $this === self::Approved;
    }

    public function isDecided(): bool
    {
        return $this !== self::Pending;
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $s) => $s->value, self::cases());
    }
}
