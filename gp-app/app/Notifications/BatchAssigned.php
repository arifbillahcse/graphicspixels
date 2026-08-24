<?php

namespace App\Notifications;

use App\Models\Batch;

class BatchAssigned extends BaseNotification
{
    public function __construct(public Batch $batch) {}

    public function key(): string
    {
        return 'batch.assigned';
    }

    public function title(): string
    {
        return "{$this->batch->label()} of {$this->batch->order->reference} is yours";
    }

    public function body(): string
    {
        return sprintf(
            '%s images of %s, due %s.',
            number_format($this->batch->image_count),
            $this->batch->order->service_type->label(),
            $this->batch->order->deadline?->format('D j M, H:i') ?? 'soon',
        );
    }

    public function url(): string
    {
        return route('batches.mine');
    }
}
