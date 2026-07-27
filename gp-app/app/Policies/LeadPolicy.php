<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

/**
 * Maps lead abilities onto the permissions seeded in Phase 1. Admins hold every
 * permission, so they pass all of these implicitly.
 */
class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('leads.view');
    }

    public function view(User $user, Lead $lead): bool
    {
        return $user->can('leads.view');
    }

    public function create(User $user): bool
    {
        return $user->can('leads.create');
    }

    public function update(User $user, Lead $lead): bool
    {
        return $user->can('leads.update');
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $user->can('leads.delete');
    }

    public function assign(User $user, Lead $lead): bool
    {
        return $user->can('leads.assign');
    }

    /**
     * Model-less variants for bulk actions, where the ability is checked once
     * against the class rather than per record.
     */
    public function updateAny(User $user): bool
    {
        return $user->can('leads.update');
    }

    public function assignAny(User $user): bool
    {
        return $user->can('leads.assign');
    }
}
