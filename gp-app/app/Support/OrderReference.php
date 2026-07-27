<?php

namespace App\Support;

/**
 * Human-facing order reference, e.g. GP-2026-0042. Staff quote these to
 * clients, so they are stable and readable rather than raw database ids.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class OrderReference
{
    public const PREFIX = 'GP';

    public static function format(int $sequence, ?int $year = null): string
    {
        $year ??= (int) date('Y');

        return sprintf('%s-%d-%04d', self::PREFIX, $year, max(1, $sequence));
    }

    /**
     * Pull the sequence number back out of a reference, or null if it does not
     * match the expected shape.
     */
    public static function sequenceOf(string $reference): ?int
    {
        if (! preg_match('/^'.self::PREFIX.'-(\d{4})-(\d+)$/', trim($reference), $m)) {
            return null;
        }

        return (int) $m[2];
    }

    public static function yearOf(string $reference): ?int
    {
        if (! preg_match('/^'.self::PREFIX.'-(\d{4})-(\d+)$/', trim($reference), $m)) {
            return null;
        }

        return (int) $m[1];
    }
}
