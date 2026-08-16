<?php

namespace App\Support;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * An inclusive range of calendar days, held as Y-m-d strings.
 *
 * Leave, reporting windows and availability all reduce to "do these two spans
 * of days touch", so that logic lives here once. Y-m-d sorts lexicographically,
 * which keeps the comparisons trivial and makes the same values usable directly
 * in SQL.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class DateRange
{
    public readonly string $start;

    public readonly string $end;

    /**
     * Dates are ordered on construction, so a range built back-to-front still
     * behaves sensibly rather than silently matching nothing.
     */
    public function __construct(string $start, string $end)
    {
        [$this->start, $this->end] = $start <= $end ? [$start, $end] : [$end, $start];
    }

    public static function of(DateTimeInterface $start, DateTimeInterface $end): self
    {
        return new self($start->format('Y-m-d'), $end->format('Y-m-d'));
    }

    /**
     * A single day.
     */
    public static function day(string $date): self
    {
        return new self($date, $date);
    }

    /**
     * The Monday-to-Sunday week containing the given date.
     */
    public static function week(?string $date = null): self
    {
        $base = new DateTimeImmutable($date ?? 'today');

        // ISO weeks start on Monday; N is 1 (Mon) to 7 (Sun).
        $monday = $base->modify('-'.((int) $base->format('N') - 1).' days');

        return new self($monday->format('Y-m-d'), $monday->modify('+6 days')->format('Y-m-d'));
    }

    /**
     * The calendar month containing the given date.
     */
    public static function month(?string $date = null): self
    {
        $base = new DateTimeImmutable($date ?? 'today');

        return new self(
            $base->format('Y-m-01'),
            $base->modify('last day of this month')->format('Y-m-d'),
        );
    }

    /**
     * Two ranges touch if neither finishes before the other starts. Ranges are
     * inclusive, so sharing a single day counts as an overlap — which is what
     * makes a one-day leave request block that day.
     */
    public function overlaps(self $other): bool
    {
        return $this->start <= $other->end && $other->start <= $this->end;
    }

    public function contains(string $date): bool
    {
        return $date >= $this->start && $date <= $this->end;
    }

    /**
     * Length in days, counting both ends.
     */
    public function days(): int
    {
        $start = new DateTimeImmutable($this->start);
        $end = new DateTimeImmutable($this->end);

        return (int) $start->diff($end)->days + 1;
    }

    public function isSingleDay(): bool
    {
        return $this->start === $this->end;
    }

    /**
     * The instant after the last day, for `< end` comparisons against datetime
     * columns — a timestamp at 14:00 on the final day is inside the range, but
     * `<= end` against a Y-m-d string would exclude it.
     */
    public function endExclusive(): string
    {
        return (new DateTimeImmutable($this->end))->modify('+1 day')->format('Y-m-d');
    }

    public function previous(): self
    {
        $length = $this->days();
        $start = new DateTimeImmutable($this->start);

        return new self(
            $start->modify("-{$length} days")->format('Y-m-d'),
            $start->modify('-1 day')->format('Y-m-d'),
        );
    }

    public function label(): string
    {
        if ($this->isSingleDay()) {
            return (new DateTimeImmutable($this->start))->format('j M Y');
        }

        return (new DateTimeImmutable($this->start))->format('j M').' – '
            .(new DateTimeImmutable($this->end))->format('j M Y');
    }

    public function __toString(): string
    {
        return $this->start.'..'.$this->end;
    }
}
