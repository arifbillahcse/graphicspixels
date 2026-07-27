<?php

namespace App\Enums;

/**
 * Entries in a lead's activity log. Activities recorded by the webhook have no
 * user attached; everything else records who did it.
 */
enum ActivityAction: string
{
    case Created = 'created';
    case StatusChanged = 'status_changed';
    case Assigned = 'assigned';
    case Unassigned = 'unassigned';
    case NoteAdded = 'note_added';
    case AttachmentStored = 'attachment_stored';
    case AttachmentFailed = 'attachment_failed';
    case DuplicateReceived = 'duplicate_received';

    public function label(): string
    {
        return match ($this) {
            self::Created => 'Lead created',
            self::StatusChanged => 'Status changed',
            self::Assigned => 'Assigned',
            self::Unassigned => 'Unassigned',
            self::NoteAdded => 'Note added',
            self::AttachmentStored => 'Attachment stored',
            self::AttachmentFailed => 'Attachment failed',
            self::DuplicateReceived => 'Duplicate submission received',
        };
    }
}
