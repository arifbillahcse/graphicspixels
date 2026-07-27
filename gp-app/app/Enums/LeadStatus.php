<?php

namespace App\Enums;

/**
 * Stages of the lead pipeline, in board order.
 */
enum LeadStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case TrialSent = 'trial_sent';
    case Negotiating = 'negotiating';
    case Converted = 'converted';
    case Lost = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Contacted => 'Contacted',
            self::TrialSent => 'Trial Sent',
            self::Negotiating => 'Negotiating',
            self::Converted => 'Converted',
            self::Lost => 'Lost',
        };
    }

    /**
     * Tailwind classes for the status badge.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::New => 'bg-blue-100 text-blue-800',
            self::Contacted => 'bg-indigo-100 text-indigo-800',
            self::TrialSent => 'bg-amber-100 text-amber-800',
            self::Negotiating => 'bg-purple-100 text-purple-800',
            self::Converted => 'bg-green-100 text-green-800',
            self::Lost => 'bg-gray-200 text-gray-700',
        };
    }

    /**
     * Closed stages: the lead has left the active pipeline.
     */
    public function isClosed(): bool
    {
        return in_array($this, [self::Converted, self::Lost], true);
    }

    /**
     * Board columns in pipeline order.
     *
     * @return list<self>
     */
    public static function pipeline(): array
    {
        return self::cases();
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $s) => $s->value, self::cases());
    }
}
