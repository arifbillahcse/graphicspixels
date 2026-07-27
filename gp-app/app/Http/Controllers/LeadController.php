<?php

namespace App\Http\Controllers;

use App\Enums\ActivityAction;
use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Enums\RoleName;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Lead::class);

        $filters = [
            'status' => $request->string('status')->toString() ?: null,
            'source' => $request->string('source')->toString() ?: null,
            'assigned' => $request->string('assigned')->toString() ?: null,
            'q' => $request->string('q')->toString() ?: null,
        ];

        $view = $request->string('view')->toString() === 'table' ? 'table' : 'board';

        $query = Lead::query()
            ->with('assignee')
            ->source($filters['source'])
            ->assignedTo($filters['assigned'])
            ->search($filters['q']);

        if ($view === 'table') {
            $leads = (clone $query)
                ->status($filters['status'])
                ->latest()
                ->paginate(25)
                ->withQueryString();

            $board = null;
        } else {
            // The board shows every column, so the status filter is ignored here.
            $leads = null;
            $board = (clone $query)
                ->latest()
                ->get()
                ->groupBy(fn (Lead $lead) => $lead->status->value);
        }

        return view('leads.index', [
            'view' => $view,
            'filters' => $filters,
            'leads' => $leads,
            'board' => $board,
            'statuses' => LeadStatus::cases(),
            'sources' => LeadSource::cases(),
            'assignees' => $this->assignableUsers(),
            'counts' => $this->statusCounts(),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Lead::class);

        return view('leads.create', [
            'statuses' => LeadStatus::cases(),
            'sources' => LeadSource::cases(),
            'assignees' => $this->assignableUsers(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Lead::class);

        $data = $this->validateLead($request);

        $lead = Lead::create($data + [
            'source' => $data['source'] ?? LeadSource::Manual->value,
            'submitted_at' => now(),
        ]);

        $lead->recordActivity(
            ActivityAction::Created,
            $request->user(),
            'Added manually.',
        );

        return redirect()
            ->route('leads.show', $lead)
            ->with('status', 'Lead created.');
    }

    public function show(Lead $lead): View
    {
        Gate::authorize('view', $lead);

        $lead->load(['assignee', 'attachments', 'activities.user']);

        return view('leads.show', [
            'lead' => $lead,
            'statuses' => LeadStatus::cases(),
            'assignees' => $this->assignableUsers(),
        ]);
    }

    public function edit(Lead $lead): View
    {
        Gate::authorize('update', $lead);

        return view('leads.edit', [
            'lead' => $lead,
            'statuses' => LeadStatus::cases(),
            'sources' => LeadSource::cases(),
            'assignees' => $this->assignableUsers(),
        ]);
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('update', $lead);

        $lead->update($this->validateLead($request));

        return redirect()
            ->route('leads.show', $lead)
            ->with('status', 'Lead updated.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        Gate::authorize('delete', $lead);

        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->with('status', 'Lead deleted.');
    }

    /**
     * Move a lead to another pipeline stage.
     */
    public function updateStatus(Request $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('update', $lead);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', LeadStatus::values())],
        ]);

        $lead->changeStatus(LeadStatus::from($validated['status']), $request->user());

        return back()->with('status', 'Lead moved to '.LeadStatus::from($validated['status'])->label().'.');
    }

    /**
     * Assign, or with an empty value unassign, the lead.
     */
    public function assign(Request $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('assign', $lead);

        $validated = $request->validate([
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $assignee = isset($validated['assigned_to'])
            ? User::find($validated['assigned_to'])
            : null;

        $lead->assignTo($assignee, $request->user());

        return back()->with('status', $assignee ? "Assigned to {$assignee->name}." : 'Lead unassigned.');
    }

    /**
     * Append a note to the activity log.
     */
    public function storeNote(Request $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('update', $lead);

        $validated = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $lead->recordActivity(ActivityAction::NoteAdded, $request->user(), $validated['note']);

        return back()->with('status', 'Note added.');
    }

    /**
     * Apply a status change or assignment to several leads at once.
     */
    public function bulk(Request $request): RedirectResponse
    {
        Gate::authorize('updateAny', Lead::class);

        $validated = $request->validate([
            'action' => ['required', 'string', 'in:status,assign'],
            'lead_ids' => ['required', 'array', 'min:1'],
            'lead_ids.*' => ['integer', 'exists:leads,id'],
            'status' => ['required_if:action,status', 'nullable', 'string', 'in:'.implode(',', LeadStatus::values())],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        if ($validated['action'] === 'assign') {
            Gate::authorize('assignAny', Lead::class);
        }

        $leads = Lead::whereIn('id', $validated['lead_ids'])->get();
        $actor = $request->user();
        $changed = 0;

        foreach ($leads as $lead) {
            $changed += $validated['action'] === 'status'
                ? (int) $lead->changeStatus(LeadStatus::from($validated['status']), $actor)
                : (int) $lead->assignTo(
                    isset($validated['assigned_to']) ? User::find($validated['assigned_to']) : null,
                    $actor,
                );
        }

        return back()->with('status', "Updated {$changed} of ".$leads->count().' leads.');
    }

    /**
     * Staff who can own a lead: the marketing team plus administrators.
     */
    private function assignableUsers()
    {
        return User::query()
            ->whereHas('roles', fn ($q) => $q->whereIn('name', [
                RoleName::MarketingManager->value,
                RoleName::Admin->value,
            ]))
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * @return array<string,int>
     */
    private function statusCounts(): array
    {
        $counts = Lead::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        $result = [];

        foreach (LeadStatus::cases() as $status) {
            $result[$status->value] = (int) ($counts[$status->value] ?? 0);
        }

        return $result;
    }

    private function validateLead(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'service' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'file_link' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'string', 'in:'.implode(',', LeadStatus::values())],
            'source' => ['nullable', 'string', 'in:'.implode(',', LeadSource::values())],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);
    }
}
