<?php

namespace App\Jobs;

use App\Enums\ActivityAction;
use App\Models\LeadAttachment;
use App\Support\AttachmentFilename;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Copies an attachment from the WordPress media library into local storage.
 *
 * The theme sends a URL rather than the file itself, and its webhook call times
 * out after 8 seconds, so the download happens out of band. Run a queue worker
 * (QUEUE_CONNECTION=database) or this executes inline and blocks the response.
 */
class FetchLeadAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public array $backoff = [30, 120];

    public function __construct(public LeadAttachment $attachment) {}

    public function handle(): void
    {
        $attachment = $this->attachment->fresh();

        if ($attachment === null || $attachment->isStored() || ! $attachment->source_url) {
            return;
        }

        $maxBytes = (int) config('graphicspixels.attachments.max_bytes');
        $disk = $attachment->disk ?: (string) config('graphicspixels.attachments.disk');

        $response = Http::timeout((int) config('graphicspixels.attachments.timeout'))
            ->get($attachment->source_url);

        if (! $response->successful()) {
            $this->fail_($attachment, "Download failed with HTTP {$response->status()}.");

            return;
        }

        $body = $response->body();
        $size = strlen($body);

        if ($size === 0) {
            $this->fail_($attachment, 'Downloaded file was empty.');

            return;
        }

        if ($size > $maxBytes) {
            $this->fail_($attachment, sprintf('File is %d bytes, over the %d byte limit.', $size, $maxBytes));

            return;
        }

        $filename = AttachmentFilename::fromUrl($attachment->source_url);
        $path = sprintf('leads/%d/%d-%s', $attachment->lead_id, $attachment->id, $filename);

        Storage::disk($disk)->put($path, $body);

        $attachment->update([
            'disk' => $disk,
            'path' => $path,
            'filename' => $filename,
            'mime_type' => $response->header('Content-Type') ?: null,
            'size' => $size,
            'status' => LeadAttachment::STATUS_STORED,
            'error' => null,
        ]);

        $attachment->lead->recordActivity(
            ActivityAction::AttachmentStored,
            null,
            sprintf('Stored attachment "%s".', $filename),
            ['attachment_id' => $attachment->id],
        );
    }

    /**
     * Record a terminal failure against the attachment and the lead's log.
     */
    public function failed(Throwable $exception): void
    {
        $attachment = $this->attachment->fresh();

        if ($attachment !== null && ! $attachment->isStored()) {
            $this->fail_($attachment, $exception->getMessage());
        }
    }

    private function fail_(LeadAttachment $attachment, string $reason): void
    {
        $attachment->update([
            'status' => LeadAttachment::STATUS_FAILED,
            'error' => mb_substr($reason, 0, 1000),
        ]);

        $attachment->lead->recordActivity(
            ActivityAction::AttachmentFailed,
            null,
            $reason,
            ['attachment_id' => $attachment->id],
        );
    }
}
