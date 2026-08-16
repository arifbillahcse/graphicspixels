<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;

/**
 * Anyone may ask for leave for themselves. Deciding it belongs to whoever
 * manages that person: HR/admin through staff.manage, or the requester's own
 * team leader — the same ownership pattern used for orders, so a team leader
 * can run their team without being handed studio-wide staff rights.
 */
class LeaveRequestPolicy
{
    /**
     * The full list across the studio, rather than one's own.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('staff.manage') || $user->can('staff.workload.view');
    }

    public function view(User $user, LeaveRequest $request): bool
    {
        return $this->owns($user, $request) || $this->manages($user, $request);
    }

    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Deciding your own leave is never allowed, even with staff.manage.
     */
    public function decide(User $user, LeaveRequest $request): bool
    {
        if ($this->owns($user, $request)) {
            return false;
        }

        if ($request->status->isDecided()) {
            return false;
        }

        return $this->manages($user, $request);
    }

    /**
     * A request can be withdrawn by the person who made it, while it is still
     * pending, or cancelled by a manager at any point before it starts.
     */
    public function cancel(User $user, LeaveRequest $request): bool
    {
        if ($this->owns($user, $request)) {
            return ! $request->status->isDecided();
        }

        return $this->manages($user, $request);
    }

    private function owns(User $user, LeaveRequest $request): bool
    {
        return $request->user_id === $user->id;
    }

    private function manages(User $user, LeaveRequest $request): bool
    {
        if ($user->can('staff.manage')) {
            return true;
        }

        // Team leaders decide for the editors reporting to them.
        return $request->user?->team_leader_id !== null
            && $request->user->team_leader_id === $user->id;
    }
}
