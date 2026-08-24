<?php

namespace App\Notifications;

use App\Models\Order;

class OrderAtRisk extends BaseNotification
{
    public function __construct(public Order $order) {}

    public function key(): string
    {
        return 'order.at_risk';
    }

    public function title(): string
    {
        return "{$this->order->reference} is close to breaching its deadline";
    }

    public function body(): string
    {
        $sla = $this->order->sla();

        return sprintf(
            '%s for %s is %s and still in %s. %s%% of the delivery window has gone.',
            number_format($this->order->image_count).' images',
            $this->order->client?->displayName() ?? 'a client',
            $sla->label(),
            $this->order->status->label(),
            number_format($sla->percentElapsed(), 0),
        );
    }

    public function url(): string
    {
        return route('orders.show', $this->order);
    }
}
