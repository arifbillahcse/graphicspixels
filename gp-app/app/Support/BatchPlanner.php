<?php

namespace App\Support;

/**
 * Splits an order's images into batches and distributes them across editors.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class BatchPlanner
{
    /**
     * Split into a fixed number of batches, as evenly as possible. Any
     * remainder is spread one image at a time over the earliest batches, so
     * sizes never differ by more than one.
     *
     * More batches than images is meaningless, so the count is clamped.
     *
     * @return list<int> image count per batch
     */
    public static function byCount(int $imageCount, int $batchCount): array
    {
        if ($imageCount < 1 || $batchCount < 1) {
            return [];
        }

        $batchCount = min($batchCount, $imageCount);

        $base = intdiv($imageCount, $batchCount);
        $remainder = $imageCount % $batchCount;

        $batches = [];

        for ($i = 0; $i < $batchCount; $i++) {
            $batches[] = $base + ($i < $remainder ? 1 : 0);
        }

        return $batches;
    }

    /**
     * Split into batches of a given size, with a smaller final batch when the
     * total does not divide evenly.
     *
     * @return list<int> image count per batch
     */
    public static function bySize(int $imageCount, int $batchSize): array
    {
        if ($imageCount < 1 || $batchSize < 1) {
            return [];
        }

        $batches = [];
        $remaining = $imageCount;

        while ($remaining > 0) {
            $take = min($batchSize, $remaining);
            $batches[] = $take;
            $remaining -= $take;
        }

        return $batches;
    }

    /**
     * Distribute batches across editors, always giving the next batch to the
     * editor carrying the least work. Ties are broken by the order editors were
     * supplied in, which keeps the result deterministic and makes plain
     * round-robin fall out naturally when everyone starts level.
     *
     * @param  int  $batchCount  number of batches to place
     * @param  array<int|string,int>  $editorLoads  editor id => open batches already held
     * @return list<int|string> editor id per batch, in batch order
     */
    public static function assign(int $batchCount, array $editorLoads): array
    {
        if ($batchCount < 1 || $editorLoads === []) {
            return [];
        }

        // Copy so the caller's array is untouched as loads are incremented.
        $loads = $editorLoads;
        $assignments = [];

        for ($i = 0; $i < $batchCount; $i++) {
            $chosen = null;
            $lowest = null;

            foreach ($loads as $editorId => $load) {
                if ($lowest === null || $load < $lowest) {
                    $lowest = $load;
                    $chosen = $editorId;
                }
            }

            $assignments[] = $chosen;
            $loads[$chosen]++;
        }

        return $assignments;
    }

    /**
     * Convenience: plan sizes and their owners in one call.
     *
     * @param  array<int|string,int>  $editorLoads
     * @return list<array{images:int,editor_id:int|string|null}>
     */
    public static function plan(array $batchSizes, array $editorLoads): array
    {
        $owners = self::assign(count($batchSizes), $editorLoads);

        $plan = [];

        foreach ($batchSizes as $index => $images) {
            $plan[] = [
                'images' => $images,
                'editor_id' => $owners[$index] ?? null,
            ];
        }

        return $plan;
    }
}
