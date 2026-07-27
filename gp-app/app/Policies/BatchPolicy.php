<?php

namespace App\Policies;

use App\Models\Batch;
use App\Models\User;

/**
 * Editors hold batches.view and batches.update.own only, so they can see and
 * progress their own work and nothing else. Managers and the responsible team
 * leader can see and reassign everything on the order.
 */
class BatchPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('batches.view');
    }

    public function view(User $user, Batch $batch): bool
    {
        if (! $user->can('batches.view')) {
            return false;
        }

        return $this->owns($user, $batch)
            || $user->can('orders.view')
            || $user->can('batches.assign');
    }

    /**
     * Progressing a batch: the assigned editor, or anyone who can reassign
     * batches in the first place.
     */
    public function update(User $user, Batch $batch): bool
    {
        if ($this->owns($user, $batch) && $user->can('batches.update.own')) {
            return true;
        }

        return $user->can('batches.assign');
    }

    public function assign(User $user, Batch $batch): bool
    {
        return $user->can('batches.assign');
    }

    private function owns(User $user, Batch $batch): bool
    {
        return $batch->editor_id !== null && $batch->editor_id === $user->id;
    }
}
