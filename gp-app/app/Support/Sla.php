<?php

namespace App\Support;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * Countdown and risk banding for an order's delivery deadline.
 *
 * The brief specifies two different rules, and both are implemented because
 * they answer different questions:
 *
 *  - risk() drives the colour of a board card, using the stated hour bands:
 *    green over 12h remaining, amber 4-12h, red under 4h.
 *  - isAtRisk() drives the "orders at risk" management widget, using the
 *    stated 80%-of-SLA-elapsed rule.
 *
 * On the studio's standard 24-hour turnaround these do not coincide: 80%
 * elapsed leaves 4.8 hours, so an order becomes "at risk" for the widget at
 * roughly the point its card turns red.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class Sla
{
    public const RISK_OK = 'ok';

    public const RISK_WARNING = 'warning';

    public const RISK_CRITICAL = 'critical';

    public const RISK_BREACHED = 'breached';

    public const RISK_MET = 'met';

    public const RISK_MISSED = 'missed';

    private const WARNING_HOURS = 12;

    private const CRITICAL_HOURS = 4;

    private const AT_RISK_PERCENT = 80.0;

    private DateTimeImmutable $startedAt;

    private DateTimeImmutable $deadline;

    private ?DateTimeImmutable $completedAt;

    private DateTimeImmutable $now;

    public function __construct(
        DateTimeInterface $startedAt,
        DateTimeInterface $deadline,
        ?DateTimeInterface $completedAt = null,
        ?DateTimeInterface $now = null,
    ) {
        $this->startedAt = self::immutable($startedAt);
        $this->deadline = self::immutable($deadline);
        $this->completedAt = $completedAt ? self::immutable($completedAt) : null;
        $this->now = $now ? self::immutable($now) : new DateTimeImmutable();
    }

    public function isComplete(): bool
    {
        return $this->completedAt !== null;
    }

    /**
     * Minutes left before the deadline; negative once it has passed. For a
     * completed order this is measured at the moment of delivery, so a
     * delivered order's figure stops moving.
     */
    public function minutesRemaining(): int
    {
        $reference = $this->completedAt ?? $this->now;

        return (int) round(($this->deadline->getTimestamp() - $reference->getTimestamp()) / 60);
    }

    public function hoursRemaining(): float
    {
        return $this->minutesRemaining() / 60;
    }

    /**
     * How much of the SLA window has been consumed. Can exceed 100 once the
     * deadline has passed.
     */
    public function percentElapsed(): float
    {
        $window = $this->deadline->getTimestamp() - $this->startedAt->getTimestamp();

        if ($window <= 0) {
            return 100.0;
        }

        $reference = $this->completedAt ?? $this->now;
        $used = $reference->getTimestamp() - $this->startedAt->getTimestamp();

        return max(0.0, round($used / $window * 100, 1));
    }

    public function isBreached(): bool
    {
        return $this->minutesRemaining() < 0;
    }

    /**
     * The management-widget rule: 80% or more of the window consumed, and the
     * order is not yet delivered.
     */
    public function isAtRisk(): bool
    {
        if ($this->isComplete()) {
            return false;
        }

        return $this->percentElapsed() >= self::AT_RISK_PERCENT;
    }

    /**
     * Risk band for the board card.
     */
    public function risk(): string
    {
        if ($this->isComplete()) {
            return $this->isBreached() ? self::RISK_MISSED : self::RISK_MET;
        }

        if ($this->isBreached()) {
            return self::RISK_BREACHED;
        }

        $hours = $this->hoursRemaining();

        return match (true) {
            $hours < self::CRITICAL_HOURS => self::RISK_CRITICAL,
            $hours < self::WARNING_HOURS => self::RISK_WARNING,
            default => self::RISK_OK,
        };
    }

    public function badgeClasses(): string
    {
        return match ($this->risk()) {
            self::RISK_OK => 'bg-green-100 text-green-800',
            self::RISK_WARNING => 'bg-amber-100 text-amber-800',
            self::RISK_CRITICAL => 'bg-red-100 text-red-800',
            self::RISK_BREACHED => 'bg-red-600 text-white',
            self::RISK_MET => 'bg-green-100 text-green-800',
            self::RISK_MISSED => 'bg-gray-800 text-white',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Short countdown for a card, e.g. "6h 12m left" or "1d 2h over".
     */
    public function label(): string
    {
        $minutes = $this->minutesRemaining();
        $suffix = $minutes < 0 ? 'over' : 'left';

        if ($this->isComplete()) {
            $suffix = $minutes < 0 ? 'late' : 'early';
        }

        return self::humanise(abs($minutes)).' '.$suffix;
    }

    private static function humanise(int $minutes): string
    {
        if ($minutes < 60) {
            return $minutes.'m';
        }

        $hours = intdiv($minutes, 60);
        $remainder = $minutes % 60;

        if ($hours < 24) {
            return $remainder > 0 ? "{$hours}h {$remainder}m" : "{$hours}h";
        }

        $days = intdiv($hours, 24);
        $hoursLeft = $hours % 24;

        return $hoursLeft > 0 ? "{$days}d {$hoursLeft}h" : "{$days}d";
    }

    private static function immutable(DateTimeInterface $date): DateTimeImmutable
    {
        return $date instanceof DateTimeImmutable
            ? $date
            : DateTimeImmutable::createFromFormat('U', (string) $date->getTimestamp());
    }
}
