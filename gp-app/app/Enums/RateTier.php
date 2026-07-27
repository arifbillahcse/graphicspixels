<?php

namespace App\Enums;

/**
 * Pricing tier a client sits on. Rates mirror the public pricing page, which
 * starts at $0.19 per image.
 */
enum RateTier: string
{
    case Standard = 'standard';
    case Volume = 'volume';
    case Enterprise = 'enterprise';

    public function label(): string
    {
        return match ($this) {
            self::Standard => 'Standard',
            self::Volume => 'Volume',
            self::Enterprise => 'Enterprise',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Standard => 'Pay as you go, from $0.19 per image',
            self::Volume => 'Discounted rate for recurring high-volume work',
            self::Enterprise => 'Negotiated contract rate with dedicated capacity',
        };
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $s) => $s->value, self::cases());
    }
}
