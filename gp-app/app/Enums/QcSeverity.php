<?php

namespace App\Enums;

/**
 * How serious a QC finding is.
 *
 * A blocker means the batch cannot ship as it stands. A minor is worth telling
 * the editor about but would not on its own hold delivery — it is recorded so
 * patterns show up in the defect figures.
 */
enum QcSeverity: string
{
    case Blocker = 'blocker';
    case Minor = 'minor';

    public function label(): string
    {
        return match ($this) {
            self::Blocker => 'Blocker',
            self::Minor => 'Minor',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Blocker => 'bg-red-100 text-red-800',
            self::Minor => 'bg-amber-100 text-amber-800',
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
