<?php

namespace App\Enums;

/**
 * Lifecycle of a single batch of images within an order.
 */
enum BatchStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case ReadyForQc = 'ready_for_qc';
    case Revision = 'revision';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::InProgress => 'In Progress',
            self::ReadyForQc => 'Ready for QC',
            self::Revision => 'Revision',
            self::Completed => 'Completed',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-gray-100 text-gray-700',
            self::InProgress => 'bg-amber-100 text-amber-800',
            self::ReadyForQc => 'bg-purple-100 text-purple-800',
            self::Revision => 'bg-orange-100 text-orange-800',
            self::Completed => 'bg-green-100 text-green-800',
        };
    }

    /**
     * Batches an editor still has to act on, used for workload balancing.
     */
    public function isOpen(): bool
    {
        return in_array($this, [self::Pending, self::InProgress, self::Revision], true);
    }

    /**
     * Transitions an editor may make on their own batch. Moving a batch to
     * Completed is a QC decision, not the editor's, and lands in phase 4.
     */
    public function editorCanMoveTo(): array
    {
        return match ($this) {
            self::Pending => [self::InProgress],
            self::InProgress => [self::ReadyForQc],
            self::Revision => [self::InProgress],
            default => [],
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
