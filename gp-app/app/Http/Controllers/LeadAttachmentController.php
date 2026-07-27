<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadAttachment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadAttachmentController extends Controller
{
    /**
     * Stream a stored attachment to an authorised user.
     *
     * Files live outside the public directory, so this route is the only way to
     * reach them. The attachment is checked against the lead in the URL so an
     * ID from another lead cannot be substituted.
     */
    public function download(Lead $lead, LeadAttachment $attachment): StreamedResponse
    {
        Gate::authorize('view', $lead);

        abort_unless($attachment->lead_id === $lead->id, 404);
        abort_unless($attachment->isStored(), 404);

        $disk = Storage::disk($attachment->disk);

        abort_unless($disk->exists($attachment->path), 404);

        return $disk->download($attachment->path, $attachment->filename ?: 'attachment');
    }
}
