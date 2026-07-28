<?php

namespace App\Models;

use App\Support\DefectRate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Monthly QC rollup per editor.
 *
 * Maintained as reviews complete rather than by a nightly job, so the figures
 * on the dashboard are never a day behind. rebuildFor() recalculates a period
 * from the underlying reviews if the two ever drift.
 */
class DefectStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'editor_id',
        'period',
        'total_reviews',
        'rejected_count',
        'reject_rate',
    ];

    protected function casts(): array
    {
        return [
            'total_reviews' => 'integer',
            'rejected_count' => 'integer',
            'reject_rate' => 'float',
        ];
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    /**
     * Fold one completed review into the editor's running totals.
     */
    public static function record(int $editorId, bool $rejected, ?string $period = null): self
    {
        $period ??= DefectRate::period();

        $stat = self::firstOrCreate(
            ['editor_id' => $editorId, 'period' => $period],
            ['total_reviews' => 0, 'rejected_count' => 0, 'reject_rate' => 0],
        );

        $stat->total_reviews++;

        if ($rejected) {
            $stat->rejected_count++;
        }

        $stat->reject_rate = DefectRate::calculate($stat->total_reviews, $stat->rejected_count);
        $stat->save();

        return $stat;
    }

    /**
     * Recalculate a period straight from the reviews, for repair or backfill.
     */
    public static function rebuildFor(string $period): int
    {
        $rows = QcReview::query()
            ->selectRaw('editor_id, COUNT(*) as total, SUM(CASE WHEN outcome = ? THEN 1 ELSE 0 END) as rejected', ['rejected'])
            ->whereNotNull('editor_id')
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $period.'-01 00:00:00')
            ->where('completed_at', '<', date('Y-m-d', strtotime($period.'-01 +1 month')).' 00:00:00')
            ->groupBy('editor_id')
            ->get();

        foreach ($rows as $row) {
            self::updateOrCreate(
                ['editor_id' => $row->editor_id, 'period' => $period],
                [
                    'total_reviews' => (int) $row->total,
                    'rejected_count' => (int) $row->rejected,
                    'reject_rate' => DefectRate::calculate((int) $row->total, (int) $row->rejected),
                ],
            );
        }

        return $rows->count();
    }

    public function isHigh(): bool
    {
        return DefectRate::isHigh($this->reject_rate, $this->total_reviews);
    }

    public function isSignificant(): bool
    {
        return DefectRate::isSignificant($this->total_reviews);
    }

    public function badgeClasses(): string
    {
        return DefectRate::badgeClasses($this->reject_rate, $this->total_reviews);
    }

    public function scopePeriod(Builder $query, string $period): Builder
    {
        return $query->where('period', $period);
    }
}
