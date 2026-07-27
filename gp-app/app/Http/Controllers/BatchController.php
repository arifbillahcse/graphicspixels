<?php

namespace App\Http\Controllers;

use App\Enums\BatchStatus;
use App\Enums\OrderStatus;
use App\Enums\RoleName;
use App\Models\Batch;
use App\Models\Order;
use App\Models\User;
use App\Support\BatchPlanner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BatchController extends Controller
{
    /**
     * An editor's own work queue.
     *
     * Editors deliberately have no access to the order board — it would expose
     * every client's work — so this is their view of the studio.
     */
    public function mine(Request $request): View
    {
        Gate::authorize('viewAny', Batch::class);

        $batches = Batch::query()
            ->forEditor($request->user()->id)
            ->with(['order.client'])
            ->orderByRaw('CASE WHEN status = ? THEN 0 ELSE 1 END', [BatchStatus::Revision->value])
            ->orderBy('status')
            ->get();

        return view('batches.mine', [
            'batches' => $batches,
            'openCount' => $batches->filter(fn (Batch $b) => $b->status->isOpen())->count(),
        ]);
    }

    /**
     * Split an order's remaining images into batches, optionally handing each
     * to the least-loaded editor.
     */
    public function store(Request $request, Order $order): RedirectResponse
    {
        Gate::authorize('manageBatches', $order);

        $validated = $request->validate([
            'mode' => ['required', 'string', 'in:count,size'],
            'batch_count' => ['required_if:mode,count', 'nullable', 'integer', 'min:1', 'max:500'],
            'batch_size' => ['required_if:mode,size', 'nullable', 'integer', 'min:1'],
            'auto_assign' => ['nullable', 'boolean'],
        ]);

        $remaining = $order->unbatchedImages();

        if ($remaining < 1) {
            return back()->withErrors([
                'mode' => 'Every image on this order is already covered by a batch.',
            ]);
        }

        $sizes = $validated['mode'] === 'count'
            ? BatchPlanner::byCount($remaining, (int) $validated['batch_count'])
            : BatchPlanner::bySize($remaining, (int) $validated['batch_size']);

        if ($sizes === []) {
            return back()->withErrors(['mode' => 'That split produces no batches.']);
        }

        $owners = [];

        if ($request->boolean('auto_assign')) {
            $editors = $this->availableEditors();

            if ($editors->isEmpty()) {
                return back()->withErrors(['auto_assign' => 'There are no active editors to assign to.']);
            }

            // Current workload per editor, so the split lands on whoever has
            // the least outstanding work rather than blindly round-robining.
            $loads = $editors->mapWithKeys(fn (User $e) => [$e->id => (int) $e->open_batches_count])->all();

            $owners = BatchPlanner::assign(count($sizes), $loads);
        }

        $actor = $request->user();

        DB::transaction(function () use ($order, $sizes, $owners, $actor) {
            $next = (int) $order->batches()->max('batch_number');

            foreach ($sizes as $index => $images) {
                $order->batches()->create([
                    'batch_number' => ++$next,
                    'image_count' => $images,
                    'editor_id' => $owners[$index] ?? null,
                    'status' => BatchStatus::Pending->value,
                ]);
            }

            $order->addNote(
                sprintf(
                    'Split %d images into %d batch%s%s.',
                    array_sum($sizes),
                    count($sizes),
                    count($sizes) === 1 ? '' : 'es',
                    $owners ? ' and auto-assigned them' : '',
                ),
                $actor,
            );

            // Batching is the point work actually begins.
            if ($order->status === OrderStatus::Assigned) {
                $order->changeStatus(OrderStatus::Editing, $actor);
            }
        });

        return back()->with('status', count($sizes).' batches created.');
    }

    public function assign(Request $request, Batch $batch): RedirectResponse
    {
        Gate::authorize('assign', $batch);

        $validated = $request->validate([
            'editor_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $editor = isset($validated['editor_id']) ? User::find($validated['editor_id']) : null;

        $batch->assignEditor($editor, $request->user());

        return back()->with('status', $editor ? "{$batch->label()} assigned to {$editor->name}." : 'Batch unassigned.');
    }

    /**
     * Progress a batch. Editors may only make the transitions their current
     * stage allows; managers may set any status.
     */
    public function updateStatus(Request $request, Batch $batch): RedirectResponse
    {
        Gate::authorize('update', $batch);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', BatchStatus::values())],
        ]);

        $target = BatchStatus::from($validated['status']);
        $user = $request->user();

        // A manager can override; an editor is held to the normal flow so a
        // batch cannot skip QC.
        if (! $user->can('batches.assign')) {
            $allowed = $batch->status->editorCanMoveTo();

            if (! in_array($target, $allowed, true)) {
                return back()->withErrors([
                    'status' => sprintf(
                        'A batch in %s cannot be moved to %s.',
                        $batch->status->label(),
                        $target->label(),
                    ),
                ]);
            }
        }

        $batch->changeStatus($target, $user);

        return back()->with('status', "{$batch->label()} is now {$target->label()}.");
    }

    public function storeNote(Request $request, Batch $batch): RedirectResponse
    {
        Gate::authorize('update', $batch);

        $validated = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $batch->order->addNote($validated['note'], $request->user(), $batch);

        return back()->with('status', 'Note added.');
    }

    private function availableEditors()
    {
        return User::role(RoleName::Editor->value)
            ->where('is_active', true)
            ->withCount(['batches as open_batches_count' => fn ($q) => $q->open()])
            ->orderBy('name')
            ->get();
    }
}
