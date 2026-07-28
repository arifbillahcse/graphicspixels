<?php

namespace App\Support;

/**
 * Turns raw review counts into a reject rate, with a shared threshold for what
 * counts as high so the dashboard and any future reporting agree.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class DefectRate
{
    /**
     * Rejection rate at or above which an editor is flagged for attention.
     */
    public const HIGH_THRESHOLD = 10.0;

    /**
     * Reviews below which a rate is too noisy to act on — one rejection out of
     * two reviews is 50%, and means nothing.
     */
    public const MIN_SAMPLE = 5;

    public static function calculate(int $totalReviews, int $rejected): float
    {
        if ($totalReviews < 1) {
            return 0.0;
        }

        $rejected = max(0, min($rejected, $totalReviews));

        return round($rejected / $totalReviews * 100, 1);
    }

    public static function isHigh(float $rate, int $totalReviews = self::MIN_SAMPLE): bool
    {
        return $totalReviews >= self::MIN_SAMPLE && $rate >= self::HIGH_THRESHOLD;
    }

    /**
     * Whether there is enough data for the rate to mean anything yet.
     */
    public static function isSignificant(int $totalReviews): bool
    {
        return $totalReviews >= self::MIN_SAMPLE;
    }

    public static function badgeClasses(float $rate, int $totalReviews = self::MIN_SAMPLE): string
    {
        if (! self::isSignificant($totalReviews)) {
            return 'bg-gray-100 text-gray-600';
        }

        return match (true) {
            $rate >= self::HIGH_THRESHOLD => 'bg-red-100 text-red-800',
            $rate >= 5.0 => 'bg-amber-100 text-amber-800',
            default => 'bg-green-100 text-green-800',
        };
    }

    /**
     * Period key for the monthly rollup, e.g. "2026-07".
     */
    public static function period(?\DateTimeInterface $date = null): string
    {
        return ($date ?? new \DateTimeImmutable())->format('Y-m');
    }
}
