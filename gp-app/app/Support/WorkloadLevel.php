<?php

namespace App\Support;

/**
 * How loaded an editor is, from their count of open batches.
 *
 * Bands are deliberately coarse: the point is for a team leader to glance at a
 * column of editors and see who to give the next batch to.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class WorkloadLevel
{
    public const IDLE = 'idle';

    public const LIGHT = 'light';

    public const STEADY = 'steady';

    public const HEAVY = 'heavy';

    /**
     * Open batches at or above which an editor should not take on more.
     */
    public const HEAVY_THRESHOLD = 6;

    public static function forOpenBatches(int $openBatches): string
    {
        return match (true) {
            $openBatches <= 0 => self::IDLE,
            $openBatches <= 2 => self::LIGHT,
            $openBatches <= 5 => self::STEADY,
            default => self::HEAVY,
        };
    }

    public static function label(string $level): string
    {
        return match ($level) {
            self::IDLE => 'Idle',
            self::LIGHT => 'Light',
            self::STEADY => 'Steady',
            self::HEAVY => 'Heavy',
            default => 'Unknown',
        };
    }

    /**
     * Idle reads as a prompt rather than a problem, so it is deliberately not
     * green — an editor with nothing to do is something to act on too.
     */
    public static function badgeClasses(string $level): string
    {
        return match ($level) {
            self::IDLE => 'bg-gray-100 text-gray-600',
            self::LIGHT => 'bg-green-100 text-green-800',
            self::STEADY => 'bg-amber-100 text-amber-800',
            self::HEAVY => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public static function isOverloaded(int $openBatches): bool
    {
        return $openBatches >= self::HEAVY_THRESHOLD;
    }

    /**
     * Bar width for the workload meter, capped so a very loaded editor does not
     * overflow the column.
     */
    public static function percent(int $openBatches): int
    {
        return (int) min(100, round($openBatches / self::HEAVY_THRESHOLD * 100));
    }
}
