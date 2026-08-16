<?php

namespace App\Http\Controllers;

use App\Enums\BatchStatus;
use App\Enums\Department;
use App\Enums\RoleName;
use App\Models\Batch;
use App\Models\User;
use App\Support\WorkloadLevel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StaffController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', User::class);

        $department = $request->string('department')->toString() ?: null;
        $search = $request->string('q')->toString() ?: null;

        $staff = User::query()
            ->with('roles', 'teamLeader')
            ->when($department, fn ($q) => $q->where('department', $department))
            ->when($search, fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('job_title', 'like', "%{$search}%")))
            ->orderBy('department')
            ->orderBy('name')
            ->get();

        return view('staff.index', [
            'staff' => $staff,
            'departments' => Department::cases(),
            'filters' => ['department' => $department, 'q' => $search],
            'onLeaveToday' => User::query()
                ->whereHas('leaveRequests', fn ($q) => $q->approved()
                    ->where('starts_on', '<=', now()->toDateString())
                    ->where('ends_on', '>=', now()->toDateString()))
                ->pluck('id')
                ->all(),
        ]);
    }

    public function show(User $staff): View
    {
        Gate::authorize('view', $staff);

        $staff->load(['roles', 'teamLeader', 'teamMembers', 'leaveRequests.reviewer']);

        return view('staff.show', [
            'staff' => $staff,
            'openBatches' => $staff->batches()->open()->with('order')->get(),
            'completedThisMonth' => $staff->batches()
                ->where('status', BatchStatus::Completed->value)
                ->where('updated_at', '>=', now()->startOfMonth())
                ->count(),
            'teamLeaders' => $this->teamLeaders(),
        ]);
    }

    /**
     * Live workload across the editing floor.
     */
    public function workload(Request $request): View
    {
        Gate::authorize('viewWorkload', User::class);

        $today = now()->toDateString();

        $editors = User::role(RoleName::Editor->value)
            ->where('is_active', true)
            ->with('teamLeader')
            ->withCount([
                'batches as open_batches_count' => fn ($q) => $q->open(),
                'batches as revision_count' => fn ($q) => $q->where('status', BatchStatus::Revision->value),
            ])
            ->orderBy('name')
            ->get();

        // One query for the images outstanding per editor, rather than a
        // count query per row.
        $images = Batch::query()
            ->open()
            ->whereNotNull('editor_id')
            ->selectRaw('editor_id, SUM(image_count) as images')
            ->groupBy('editor_id')
            ->pluck('images', 'editor_id');

        $onLeave = User::query()
            ->whereHas('leaveRequests', fn ($q) => $q->approved()
                ->where('starts_on', '<=', $today)
                ->where('ends_on', '>=', $today))
            ->pluck('id')
            ->all();

        $editors->each(function (User $editor) use ($images, $onLeave) {
            $editor->outstanding_images = (int) ($images[$editor->id] ?? 0);
            $editor->workload_level = WorkloadLevel::forOpenBatches($editor->open_batches_count);
            $editor->is_on_leave = in_array($editor->id, $onLeave, true);
        });

        return view('staff.workload', [
            'editors' => $editors,
            'teams' => $editors->groupBy(fn (User $e) => $e->teamLeader?->name ?? 'Unassigned'),
            'unassignedBatches' => Batch::open()->whereNull('editor_id')->count(),
            'totalOpen' => $editors->sum('open_batches_count'),
            'awayCount' => count($onLeave),
        ]);
    }

    /**
     * Update the organisational details of a staff member.
     */
    public function update(Request $request, User $staff): RedirectResponse
    {
        Gate::authorize('manage', $staff);

        $validated = $request->validate([
            'job_title' => ['nullable', 'string', 'max:255'],
            'team_leader_id' => ['nullable', 'integer', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Reporting to yourself would make the team tree cyclic.
        if (($validated['team_leader_id'] ?? null) === $staff->id) {
            return back()->withErrors(['team_leader_id' => 'Somebody cannot report to themselves.']);
        }

        $staff->update([
            'job_title' => $validated['job_title'] ?? $staff->job_title,
            'team_leader_id' => $validated['team_leader_id'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('status', "{$staff->name} updated.");
    }

    private function teamLeaders()
    {
        return User::role(RoleName::TeamLeader->value)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}
