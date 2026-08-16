<?php

namespace App\Policies;

use App\Models\User;

/**
 * The staff directory. Viewing is a management function; the workload board is
 * opened up to team leaders, who need it to distribute batches.
 */
class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('staff.view');
    }

    public function view(User $user, User $staff): bool
    {
        // Everyone can open their own profile.
        return $user->id === $staff->id || $user->can('staff.view');
    }

    public function viewWorkload(User $user): bool
    {
        return $user->can('staff.workload.view');
    }

    public function manage(User $user, User $staff): bool
    {
        return $user->can('staff.manage');
    }
}
