<?php

namespace App\Http\Controllers;

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use App\Models\LeaveRequest;
use App\Support\DateRange;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeaveRequestController extends Controller
{
    /**
     * Your own requests, plus anything awaiting your decision.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $toDecide = collect();

        if ($user->can('staff.manage')) {
            $toDecide = LeaveRequest::pending()->with('user')->orderBy('starts_on')->get();
        } elseif ($user->teamMembers()->exists()) {
            $toDecide = LeaveRequest::pending()
                ->whereIn('user_id', $user->teamMembers()->pluck('id'))
                ->with('user')
                ->orderBy('starts_on')
                ->get();
        }

        return view('leave.index', [
            'mine' => $user->leaveRequests()->with('reviewer')->get(),
            'toDecide' => $toDecide,
            'types' => LeaveType::cases(),
            'away' => LeaveRequest::approved()
                ->overlapping(DateRange::week())
                ->with('user')
                ->orderBy('starts_on')
                ->get(),
            'week' => DateRange::week(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', LeaveRequest::class);

        $validated = $request->validate([
            'type' => ['required', 'string', 'in:'.implode(',', LeaveType::values())],
            'starts_on' => ['required', 'date'],
            'ends_on' => ['required', 'date', 'after_or_equal:starts_on'],
            'reason' => ['nullable', 'string', 'max:2000'],
        ], [
            'ends_on.after_or_equal' => 'Leave cannot finish before it starts.',
        ]);

        $user = $request->user();
        $range = new DateRange($validated['starts_on'], $validated['ends_on']);

        // Two overlapping requests from one person would double-count their
        // absence and confuse the availability check.
        $clash = $user->leaveRequests()
            ->whereIn('status', [LeaveStatus::Pending->value, LeaveStatus::Approved->value])
            ->overlapping($range)
            ->exists();

        if ($clash) {
            return back()
                ->withInput()
                ->withErrors(['starts_on' => 'You already have leave booked over those dates.']);
        }

        LeaveRequest::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'starts_on' => $range->start,
            'ends_on' => $range->end,
            'reason' => $validated['reason'] ?? null,
        ]);

        return back()->with('status', 'Leave request submitted.');
    }

    public function approve(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        Gate::authorize('decide', $leaveRequest);

        $validated = $request->validate([
            'review_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $leaveRequest->approve($request->user(), $validated['review_note'] ?? null);

        return back()->with('status', "Approved leave for {$leaveRequest->user->name}.");
    }

    public function deny(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        Gate::authorize('decide', $leaveRequest);

        $validated = $request->validate([
            'review_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $leaveRequest->deny($request->user(), $validated['review_note'] ?? null);

        return back()->with('status', "Denied leave for {$leaveRequest->user->name}.");
    }

    public function cancel(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        Gate::authorize('cancel', $leaveRequest);

        $leaveRequest->cancel();

        return back()->with('status', 'Leave request cancelled.');
    }
}
