<?php

namespace App\Http\Controllers\Api;

use App\Enums\ActivityAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmissionRequest;
use App\Jobs\FetchLeadAttachment;
use App\Models\Lead;
use App\Models\LeadAttachment;
use App\Support\SubmissionPayload;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Receives form submissions forwarded by the WordPress theme.
 *
 * @see graphicspixels-theme/inc/submissions.php on the wp-graphicspixels branch
 */
class SubmissionController extends Controller
{
    public function store(StoreSubmissionRequest $request): JsonResponse
    {
        $payload = SubmissionPayload::fromArray($request->all());

        // WordPress records the forward result but does not retry automatically;
        // a manual resend or a proxy retry would otherwise duplicate the lead.
        if ($payload->wpEntryId !== null) {
            $existing = Lead::where('wp_entry_id', $payload->wpEntryId)->first();

            if ($existing) {
                return $this->duplicateResponse($existing);
            }
        }

        try {
            $lead = DB::transaction(fn () => $this->createLead($payload));
        } catch (QueryException $e) {
            // Two deliveries racing: the unique index on wp_entry_id rejected
            // the second insert. Treat it as the duplicate it is.
            $existing = $payload->wpEntryId !== null
                ? Lead::where('wp_entry_id', $payload->wpEntryId)->first()
                : null;

            if ($existing) {
                return $this->duplicateResponse($existing);
            }

            Log::error('Failed to store submission', ['exception' => $e]);

            return response()->json([
                'ok' => false,
                'error' => 'Could not store the submission.',
            ], 500);
        }

        return response()->json([
            'ok' => true,
            'duplicate' => false,
            'lead_id' => $lead->id,
            'status' => $lead->status->value,
            'source' => $lead->source->value,
            'attachments' => $lead->attachments->count(),
        ], 201);
    }

    private function createLead(SubmissionPayload $payload): Lead
    {
        $lead = Lead::create($payload->toLeadAttributes() + [
            'submitted_at' => $this->parseTimestamp($payload->submittedAt),
        ]);

        $lead->recordActivity(
            ActivityAction::Created,
            null,
            sprintf('Received from the website (%s).', $payload->source->label()),
            array_filter([
                'wp_entry_id' => $payload->wpEntryId,
                'service' => $payload->service,
            ]),
        );

        foreach ($payload->attachmentUrls as $url) {
            $attachment = $lead->attachments()->create([
                'source_url' => $url,
                'disk' => config('graphicspixels.attachments.disk'),
                'status' => LeadAttachment::STATUS_PENDING,
            ]);

            // Queued so the webhook can answer inside the theme's 8s timeout.
            FetchLeadAttachment::dispatch($attachment);
        }

        return $lead->load('attachments');
    }

    private function duplicateResponse(Lead $lead): JsonResponse
    {
        $lead->recordActivity(
            ActivityAction::DuplicateReceived,
            null,
            'The website delivered this submission again; no new lead was created.',
        );

        return response()->json([
            'ok' => true,
            'duplicate' => true,
            'lead_id' => $lead->id,
            'status' => $lead->status->value,
        ], 200);
    }

    /**
     * The theme sends an ISO-8601 timestamp in the site's timezone. Fall back
     * to now() rather than rejecting the submission over an unparseable value.
     */
    private function parseTimestamp(?string $value): Carbon
    {
        if ($value === null) {
            return now();
        }

        try {
            return Carbon::parse($value);
        } catch (Throwable) {
            return now();
        }
    }
}
