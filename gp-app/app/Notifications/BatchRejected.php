<?php

namespace App\Notifications;

use App\Models\QcReview;

class BatchRejected extends BaseNotification
{
    public function __construct(public QcReview $review) {}

    public function key(): string
    {
        return 'batch.rejected';
    }

    public function title(): string
    {
        return "QC sent {$this->review->batch->label()} of {$this->review->batch->order->reference} back";
    }

    public function body(): string
    {
        $comments = $this->review->comments;
        $blockers = $comments->where('severity', \App\Enums\QcSeverity::Blocker)->count();

        // Lead with the first finding: it is the thing that needs doing.
        $first = $comments->first()?->comment;

        return sprintf(
            '%d finding%s%s.%s',
            $comments->count(),
            $comments->count() === 1 ? '' : 's',
            $blockers > 0 ? sprintf(' (%d blocker%s)', $blockers, $blockers === 1 ? '' : 's') : '',
            $first ? ' First: '.$first : '',
        );
    }

    public function url(): string
    {
        return route('batches.mine');
    }
}
