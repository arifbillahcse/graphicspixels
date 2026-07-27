<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

/**
 * Maps order abilities onto the permissions seeded in phase 1.
 *
 * Team leaders hold orders.view but not orders.update, because they are only
 * meant to drive the orders they are responsible for. Rather than widening
 * their permission, update() also accepts ownership of the order — so a team
 * leader can work their own queue and nobody else's.
 */
class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('orders.view');
    }

    public function view(User $user, Order $order): bool
    {
        return $user->can('orders.view');
    }

    public function create(User $user): bool
    {
        return $user->can('orders.create');
    }

    public function update(User $user, Order $order): bool
    {
        return $user->can('orders.update') || $this->leads($user, $order);
    }

    public function delete(User $user, Order $order): bool
    {
        return $user->can('orders.delete');
    }

    /**
     * Handing an order to a team leader is a production-management decision.
     */
    public function assign(User $user, Order $order): bool
    {
        return $user->can('orders.assign');
    }

    /**
     * Splitting an order into batches: either the responsible team leader, or
     * a manager who can assign batches anyway.
     */
    public function manageBatches(User $user, Order $order): bool
    {
        return $user->can('batches.create') && ($this->leads($user, $order) || $user->can('orders.update'));
    }

    public function addNote(User $user, Order $order): bool
    {
        return $user->can('orders.view');
    }

    private function leads(User $user, Order $order): bool
    {
        return $order->team_leader_id !== null && $order->team_leader_id === $user->id;
    }
}
