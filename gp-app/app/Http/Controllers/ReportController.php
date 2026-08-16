<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\DefectStat;
use App\Models\Order;
use App\Support\DateRange;
use App\Support\DefectRate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewReports', Order::class);

        $range = $this->range($request);

        return view('reports.index', [
            'range' => $range,
            'scope' => $request->string('scope')->toString() === 'week' ? 'week' : 'month',
            'summary' => $this->summary($range),
            'previous' => $this->summary($range->previous()),
            'byService' => $this->byService($range),
            'editors' => $this->editorPerformance($range),
        ]);
    }

    /**
     * Streamed so a long month does not have to be built in memory first.
     */
    public function export(Request $request): StreamedResponse
    {
        Gate::authorize('exportReports', Order::class);

        $range = $this->range($request);
        $report = $request->string('report')->toString() ?: 'orders';

        $filename = sprintf('graphicspixels-%s-%s-to-%s.csv', $report, $range->start, $range->end);

        [$headers, $rows] = match ($report) {
            'services' => [
                ['Service', 'Orders', 'Images', 'Delivered', 'On time', 'On-time %'],
                $this->byService($range)->map(fn (array $r) => [
                    $r['service'], $r['orders'], $r['images'], $r['delivered'], $r['on_time'], $r['on_time_rate'],
                ]),
            ],
            'editors' => [
                ['Editor', 'Batches completed', 'Images', 'QC reviews', 'Rejected', 'Reject rate %'],
                $this->editorPerformance($range)->map(fn (array $r) => [
                    $r['name'], $r['batches'], $r['images'], $r['reviews'], $r['rejected'], $r['reject_rate'],
                ]),
            ],
            default => [
                ['Reference', 'Client', 'Service', 'Images', 'Status', 'Received', 'Deadline', 'Delivered', 'On time'],
                $this->ordersIn($range)->map(fn (Order $o) => [
                    $o->reference,
                    $o->client?->displayName(),
                    $o->service_type->label(),
                    $o->image_count,
                    $o->status->label(),
                    $o->received_at?->format('Y-m-d H:i'),
                    $o->deadline?->format('Y-m-d H:i'),
                    $o->completed_at?->format('Y-m-d H:i') ?? '',
                    $o->completed_at === null ? '' : ($o->completed_at->lessThanOrEqualTo($o->deadline) ? 'yes' : 'no'),
                ]),
            ],
        };

        return response()->streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');

            // Excel opens UTF-8 CSV as the local codepage without this.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, $headers);

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function range(Request $request): DateRange
    {
        $date = $request->string('date')->toString() ?: null;

        return $request->string('scope')->toString() === 'week'
            ? DateRange::week($date)
            : DateRange::month($date);
    }

    /**
     * Orders received within the window.
     */
    private function ordersIn(DateRange $range): Collection
    {
        return Order::query()
            ->with('client')
            ->where('received_at', '>=', $range->start)
            ->where('received_at', '<', $range->endExclusive())
            ->orderBy('received_at')
            ->get();
    }

    /**
     * @return array<string,mixed>
     */
    private function summary(DateRange $range): array
    {
        $orders = $this->ordersIn($range);
        $delivered = $orders->filter(fn (Order $o) => $o->status === OrderStatus::Delivered && $o->completed_at);

        $onTime = $delivered->filter(fn (Order $o) => $o->completed_at->lessThanOrEqualTo($o->deadline));

        // Averaged in PHP rather than SQL to stay portable across SQLite and
        // MySQL, and because the volumes here are per-month, not per-day.
        $turnarounds = $delivered->map(
            fn (Order $o) => $o->received_at->diffInMinutes($o->completed_at)
        );

        return [
            'orders' => $orders->count(),
            'images' => (int) $orders->sum('image_count'),
            'delivered' => $delivered->count(),
            'on_time' => $onTime->count(),
            'on_time_rate' => $delivered->isEmpty()
                ? 0.0
                : round($onTime->count() / $delivered->count() * 100, 1),
            'avg_turnaround_hours' => $turnarounds->isEmpty()
                ? 0.0
                : round($turnarounds->avg() / 60, 1),
            'rush' => $orders->where('rush', true)->count(),
        ];
    }

    /**
     * @return Collection<int,array<string,mixed>>
     */
    private function byService(DateRange $range): Collection
    {
        return $this->ordersIn($range)
            ->groupBy(fn (Order $o) => $o->service_type->label())
            ->map(function (Collection $orders, string $service) {
                $delivered = $orders->filter(fn (Order $o) => $o->completed_at !== null);
                $onTime = $delivered->filter(fn (Order $o) => $o->completed_at->lessThanOrEqualTo($o->deadline));

                return [
                    'service' => $service,
                    'orders' => $orders->count(),
                    'images' => (int) $orders->sum('image_count'),
                    'delivered' => $delivered->count(),
                    'on_time' => $onTime->count(),
                    'on_time_rate' => $delivered->isEmpty()
                        ? 0.0
                        : round($onTime->count() / $delivered->count() * 100, 1),
                ];
            })
            ->sortByDesc('images')
            ->values();
    }

    /**
     * Batches completed and QC outcomes per editor in the window.
     *
     * @return Collection<int,array<string,mixed>>
     */
    private function editorPerformance(DateRange $range): Collection
    {
        $batches = \App\Models\Batch::query()
            ->with('editor')
            ->whereNotNull('editor_id')
            ->where('status', \App\Enums\BatchStatus::Completed->value)
            ->where('updated_at', '>=', $range->start)
            ->where('updated_at', '<', $range->endExclusive())
            ->get()
            ->groupBy('editor_id');

        $reviews = \App\Models\QcReview::query()
            ->completed()
            ->whereNotNull('editor_id')
            ->where('completed_at', '>=', $range->start)
            ->where('completed_at', '<', $range->endExclusive())
            ->get()
            ->groupBy('editor_id');

        $editorIds = $batches->keys()->merge($reviews->keys())->unique();

        return $editorIds
            ->map(function ($editorId) use ($batches, $reviews) {
                $theirBatches = $batches->get($editorId, collect());
                $theirReviews = $reviews->get($editorId, collect());
                $rejected = $theirReviews->where('outcome', \App\Enums\QcOutcome::Rejected)->count();

                $editor = $theirBatches->first()?->editor ?? $theirReviews->first()?->editor;

                return [
                    'name' => $editor?->name ?? 'Unknown',
                    'batches' => $theirBatches->count(),
                    'images' => (int) $theirBatches->sum('image_count'),
                    'reviews' => $theirReviews->count(),
                    'rejected' => $rejected,
                    'reject_rate' => DefectRate::calculate($theirReviews->count(), $rejected),
                    'significant' => DefectRate::isSignificant($theirReviews->count()),
                ];
            })
            ->sortByDesc('images')
            ->values();
    }
}
