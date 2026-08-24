<?php

namespace App\Notifications;

use App\Models\Order;

class OrderAssigned extends BaseNotification
{
    public function __construct(public Order $order) {}

    public function key(): string
    {
        return 'order.assigned';
    }

    public function title(): string
    {
        return "Order {$this->order->reference} is yours to deliver";
    }

    public function body(): string
    {
        return sprintf(
            '%s images of %s, due %s.%s Split it into batches to get it moving.',
            number_format($this->order->image_count),
            $this->order->service_type->label(),
            $this->order->deadline?->format('D j M, H:i') ?? 'soon',
            $this->order->rush ? ' This is a rush job.' : '',
        );
    }

    public function url(): string
    {
        return route('orders.show', $this->order);
    }
}
