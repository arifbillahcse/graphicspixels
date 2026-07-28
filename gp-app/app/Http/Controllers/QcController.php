<?php

namespace App\Http\Controllers;

use App\Enums\BatchStatus;
use App\Enums\QcSeverity;
use App\Enums\RoleName;
use App\Models\Batch;
use App\Models\DefectStat;
use App\Models\QcReview;
use App\Models\User;
use App\Support\DefectRate;
use App\Support\QcChecklist;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QcController extends Controller
{
    /**
     * Everything waiting to be checked, oldest deadline first.
     */
    public function queue(Request $request): View
    {
        Gate::authorize('viewAny', QcReview::class);

        $batches = Batch::query()
            ->where('status', BatchStatus::ReadyForQc->value)
            ->with(['order.client', 'editor'])
            ->get()
            ->sortBy(fn (Batch $b) => $b->order->deadline)
            ->values();

        return view('qc.queue', [
            'batches' => $batches,
            'recent' => QcReview::completed()
                ->with(['batch.order', 'editor', 'reviewer'])
                ->latest('completed_at')
                ->limit(10)
                ->get(),
        ]);
    }

    /**
     * The review screen for one batch. Opens a pending review on first visit so
     * two reviewers looking at the same batch share one record.
     */
    public function show(Batch $batch): View
    {
        Gate::authorize('view', $batch);
        Gate::authorize('viewAny', QcReview::class);

        $batch->load(['order.client', 'editor']);

        $review = QcReview::where('batch_id', $batch->id)->pending()->first()
            ?? QcReview::openFor($batch);

        return view('qc.show', [
            'batch' => $batch,
            'review' => $review,
            'checklist' => QcChecklist::for($batch->order->service_type),
            'severities' => QcSeverity::cases(),
            'history' => QcReview::where('batch_id', $batch->id)
                ->completed()
                ->with(['comments', 'reviewer'])
                ->latest('completed_at')
                ->get(),
        ]);
    }

    public function approve(Request $request, QcReview $review): RedirectResponse
    {
        Gate::authorize('approve', $review);

        $validated = $request->validate([
            'checklist' => ['nullable', 'array'],
            'checklist.*' => ['nullable', 'string'],
        ]);

        $review->approve($request->user(), $this->normaliseChecklist($review, $validated['checklist'] ?? []));

        return redirect()
            ->route('qc.queue')
            ->with('status', "{$review->batch->label()} approved.");
    }

    public function reject(Request $request, QcReview $review): RedirectResponse
    {
        Gate::authorize('reject', $review);

        $validated = $request->validate([
            'comments' => ['required', 'array', 'min:1'],
            'comments.*.comment' => ['required', 'string', 'max:2000'],
            'comments.*.severity' => ['required', 'string', 'in:'.implode(',', QcSeverity::values())],
            'checklist' => ['nullable', 'array'],
            'checklist.*' => ['nullable', 'string'],
        ], [
            'comments.required' => 'Give the editor at least one finding to work from.',
            'comments.*.comment.required' => 'Every finding needs a description.',
        ]);

        // Drop any rows the reviewer left blank in the repeating field.
        $comments = array_values(array_filter(
            $validated['comments'],
            fn ($row) => trim($row['comment'] ?? '') !== '',
        ));

        if ($comments === []) {
            return back()->withErrors(['comments' => 'Give the editor at least one finding to work from.']);
        }

        $review->reject(
            $request->user(),
            $comments,
            $this->normaliseChecklist($review, $validated['checklist'] ?? []),
        );

        return redirect()
            ->route('qc.queue')
            ->with('status', "{$review->batch->label()} sent back for revision.");
    }

    /**
     * Per-editor reject rates for the current month.
     */
    public function defects(Request $request): View
    {
        Gate::authorize('viewDefects', QcReview::class);

        $period = $request->string('period')->toString() ?: DefectRate::period();

        $stats = DefectStat::period($period)
            ->with('editor')
            ->get()
            ->sortByDesc('reject_rate')
            ->values();

        // Editors with no reviews this month still belong in the table.
        $covered = $stats->pluck('editor_id')->all();

        $untracked = User::role(RoleName::Editor->value)
            ->where('is_active', true)
            ->whereNotIn('id', $covered ?: [0])
            ->orderBy('name')
            ->get();

        return view('qc.defects', [
            'period' => $period,
            'stats' => $stats,
            'untracked' => $untracked,
            'periods' => DefectStat::query()
                ->select('period')
                ->distinct()
                ->orderByDesc('period')
                ->pluck('period'),
        ]);
    }

    /**
     * Record the checklist as a full answered/unanswered map, so a later change
     * to the checklist cannot make an old review look complete.
     *
     * @param  list<string>  $ticked
     * @return array<string,bool>
     */
    private function normaliseChecklist(QcReview $review, array $ticked): array
    {
        $items = QcChecklist::for($review->batch->order->service_type);
        $ticked = array_map('strval', $ticked);

        $result = [];

        foreach ($items as $item) {
            $result[$item] = in_array($item, $ticked, true);
        }

        return $result;
    }
}
