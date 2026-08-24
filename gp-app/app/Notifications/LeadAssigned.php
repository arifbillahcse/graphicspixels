<?php

namespace App\Notifications;

use App\Models\Lead;

class LeadAssigned extends BaseNotification
{
    public function __construct(public Lead $lead) {}

    public function key(): string
    {
        return 'lead.assigned';
    }

    public function title(): string
    {
        return "New lead assigned to you: {$this->lead->name}";
    }

    public function body(): string
    {
        return sprintf(
            '%s enquired about %s and is now yours to follow up.',
            $this->lead->name,
            $this->lead->service ?: 'our services',
        );
    }

    public function url(): string
    {
        return route('leads.show', $this->lead);
    }
}
