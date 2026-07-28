<?php

namespace App\Policies;

use App\Models\QcReview;
use App\Models\User;

/**
 * QC sits outside the production chain of command on purpose: approving and
 * rejecting are their own permissions, so a production manager cannot sign off
 * their own team's work unless they have explicitly been given them.
 */
class QcReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('qc.view');
    }

    public function view(User $user, QcReview $review): bool
    {
        return $user->can('qc.view');
    }

    public function approve(User $user, QcReview $review): bool
    {
        return $user->can('qc.approve') && ! $review->outcome->isComplete();
    }

    public function reject(User $user, QcReview $review): bool
    {
        return $user->can('qc.reject') && ! $review->outcome->isComplete();
    }

    /**
     * Seeing how editors are performing: QC and management, not editors
     * themselves.
     */
    public function viewDefects(User $user): bool
    {
        return $user->can('qc.view') || $user->can('staff.view');
    }
}
