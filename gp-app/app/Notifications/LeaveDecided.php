<?php

namespace App\Notifications;

use App\Models\LeaveRequest;

class LeaveDecided extends BaseNotification
{
    public function __construct(public LeaveRequest $leaveRequest) {}

    public function key(): string
    {
        return 'leave.decided';
    }

    public function title(): string
    {
        return 'Your leave request was '.strtolower($this->leaveRequest->status->label());
    }

    public function body(): string
    {
        return sprintf(
            '%s (%s) was %s by %s.%s',
            $this->leaveRequest->range()->label(),
            $this->leaveRequest->type->label(),
            strtolower($this->leaveRequest->status->label()),
            $this->leaveRequest->reviewer?->name ?? 'a manager',
            $this->leaveRequest->review_note ? ' Note: '.$this->leaveRequest->review_note : '',
        );
    }

    public function url(): string
    {
        return route('leave.index');
    }
}
