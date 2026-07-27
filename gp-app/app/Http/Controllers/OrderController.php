<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\RoleName;
use App\Enums\ServiceType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * The production board: one column per pipeline stage.
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Order::class);

        return view('orders.index', $this->boardData($request, mine: $request->boolean('mine')));
    }

    /**
     * A team leader's own queue — the same board, pre-filtered to the orders
     * they are responsible for.
     */
    public function queue(Request $request): View
    {
        Gate::authorize('viewAny', Order::class);

        return view('orders.index', $this->boardData($request, mine: true) + ['isQueue' => true]);
    }

    public function show(Order $order): View
    {
        Gate::authorize('view', $order);

        $order->load([
            'client',
            'teamLeader',
            'lead',
            'batches.editor',
            'notes.user',
            'notes.batch',
        ]);

        return view('orders.show', [
            'order' => $order,
            'statuses' => OrderStatus::cases(),
            'teamLeaders' => $this->teamLeaders(),
            'editors' => $this->editors(),
        ]);
    }

    /**
     * Move an order between board columns.
     *
     * Answers JSON when called by the drag-and-drop board, and redirects back
     * when submitted from the no-JavaScript fallback form.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse|JsonResponse
    {
        Gate::authorize('update', $order);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', OrderStatus::values())],
        ]);

        $status = OrderStatus::from($validated['status']);

        // Work cannot start until somebody owns the order.
        if ($status->requiresTeamLeader() && $order->team_leader_id === null) {
            $message = 'Assign a team leader before moving this order past Received.';

            return $request->expectsJson()
                ? response()->json(['ok' => false, 'error' => $message], 422)
                : back()->withErrors(['status' => $message]);
        }

        $order->changeStatus($status, $request->user());

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'status' => $order->status->value,
                'label' => $order->status->label(),
            ]);
        }

        return back()->with('status', "{$order->reference} moved to {$status->label()}.");
    }

    public function assign(Request $request, Order $order): RedirectResponse
    {
        Gate::authorize('assign', $order);

        $validated = $request->validate([
            'team_leader_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $leader = isset($validated['team_leader_id'])
            ? User::find($validated['team_leader_id'])
            : null;

        $order->assignTeamLeader($leader, $request->user());

        return back()->with('status', $leader ? "Assigned to {$leader->name}." : 'Team leader removed.');
    }

    /**
     * Update the working details of an order: links, deadline and brief.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        Gate::authorize('update', $order);

        $validated = $request->validate([
            'file_intake_link' => ['nullable', 'string', 'max:2000'],
            'delivery_link' => ['nullable', 'string', 'max:2000'],
            'deadline' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $newDeadline = Carbon::parse($validated['deadline']);
        $deadlineChanged = ! $order->deadline->equalTo($newDeadline);

        $order->update($validated + ['deadline' => $newDeadline]);

        if ($deadlineChanged) {
            $order->addNote(
                'Deadline changed to '.$newDeadline->format('d M Y, H:i').'.',
                $request->user(),
            );
        }

        return back()->with('status', 'Order updated.');
    }

    public function storeNote(Request $request, Order $order): RedirectResponse
    {
        Gate::authorize('addNote', $order);

        $validated = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $order->addNote($validated['note'], $request->user());

        return back()->with('status', 'Note added.');
    }

    /**
     * Shared board query and view data.
     *
     * @return array<string,mixed>
     */
    private function boardData(Request $request, bool $mine): array
    {
        $filters = [
            'service_type' => $request->string('service_type')->toString() ?: null,
            'team_leader' => $request->string('team_leader')->toString() ?: null,
            'q' => $request->string('q')->toString() ?: null,
            'rush' => $request->boolean('rush'),
            'at_risk' => $request->boolean('at_risk'),
            'mine' => $mine,
        ];

        $query = Order::query()->with(['client', 'teamLeader'])->withCount('batches');

        if ($filters['service_type']) {
            $query->where('service_type', $filters['service_type']);
        }

        if ($mine) {
            $query->where('team_leader_id', $request->user()->id);
        } elseif ($filters['team_leader'] === 'unassigned') {
            $query->whereNull('team_leader_id');
        } elseif ($filters['team_leader']) {
            $query->where('team_leader_id', $filters['team_leader']);
        }

        if ($filters['rush']) {
            $query->where('rush', true);
        }

        if ($filters['at_risk']) {
            $query->atRisk();
        }

        if ($filters['q']) {
            $term = '%'.$filters['q'].'%';
            $query->where(function ($q) use ($term) {
                $q->where('reference', 'like', $term)
                    ->orWhereHas('client', fn ($c) => $c->where('name', 'like', $term)
                        ->orWhere('company', 'like', $term));
            });
        }

        $board = $query->orderBy('deadline')->get()->groupBy(fn (Order $o) => $o->status->value);

        return [
            'board' => $board,
            'statuses' => OrderStatus::cases(),
            'serviceTypes' => ServiceType::cases(),
            'teamLeaders' => $this->teamLeaders(),
            'filters' => $filters,
            'isQueue' => false,
        ];
    }

    private function teamLeaders()
    {
        return User::role(RoleName::TeamLeader->value)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    private function editors()
    {
        return User::role(RoleName::Editor->value)
            ->where('is_active', true)
            ->withCount(['batches as open_batches_count' => fn ($q) => $q->open()])
            ->orderBy('name')
            ->get();
    }
}
