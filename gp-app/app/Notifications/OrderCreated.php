<?php

namespace App\Notifications;

use App\Models\Order;

class OrderCreated extends BaseNotification
{
    public function __construct(public Order $order) {}

    public function key(): string
    {
        return 'order.created';
    }

    public function title(): string
    {
        return "New order {$this->order->reference}";
    }

    public function body(): string
    {
        return sprintf(
            '%s images of %s for %s, due %s.',
            number_format($this->order->image_count),
            $this->order->service_type->label(),
            $this->order->client?->displayName() ?? 'a client',
            $this->order->deadline?->format('D j M, H:i') ?? 'soon',
        );
    }

    public function url(): string
    {
        return route('orders.show', $this->order);
    }
}
