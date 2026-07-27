<?php

namespace App\Support;

use App\Enums\LeadSource;

/**
 * Normalises an inbound webhook body into lead attributes.
 *
 * The WordPress theme posts a slightly different shape per form: the free-trial
 * form sends `website` and `file_link`, the contact form sends `company`, and
 * both are wrapped with `form`, `submitted_at` and `wp_entry_id`. Empty fields
 * arrive as empty strings rather than being omitted, and an uploaded file
 * arrives as `attachment_url` pointing at the WordPress media library.
 *
 * Framework-independent so it can be asserted against directly.
 *
 * @see graphicspixels-theme/inc/submissions.php on the wp-graphicspixels branch
 */
final class SubmissionPayload
{
    /**
     * @param  list<string>  $attachmentUrls
     */
    private function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly ?string $website,
        public readonly ?string $company,
        public readonly ?string $service,
        public readonly ?string $message,
        public readonly ?string $fileLink,
        public readonly LeadSource $source,
        public readonly ?int $wpEntryId,
        public readonly ?string $submittedAt,
        public readonly array $attachmentUrls,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: self::text($data['name'] ?? null) ?? '',
            email: mb_strtolower(self::text($data['email'] ?? null) ?? ''),
            phone: self::text($data['phone'] ?? null),
            website: self::text($data['website'] ?? null),
            company: self::text($data['company'] ?? null),
            service: self::text($data['service'] ?? null),
            message: self::text($data['message'] ?? null, 20000),
            fileLink: self::text($data['file_link'] ?? null, 2000),
            source: self::resolveSource($data),
            wpEntryId: self::positiveInt($data['wp_entry_id'] ?? null),
            submittedAt: self::text($data['submitted_at'] ?? null),
            attachmentUrls: self::attachmentUrls($data),
        );
    }

    /**
     * Attributes for creating the Lead record. Status is deliberately omitted
     * so the model default (new) applies.
     */
    public function toLeadAttributes(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'company' => $this->company,
            'service' => $this->service,
            'message' => $this->message,
            'file_link' => $this->fileLink,
            'source' => $this->source->value,
            'wp_entry_id' => $this->wpEntryId,
        ];
    }

    public function hasAttachments(): bool
    {
        return $this->attachmentUrls !== [];
    }

    /**
     * An explicit `source` wins so the endpoint can be driven directly; the
     * theme's human-readable `form` label is the normal path.
     */
    private static function resolveSource(array $data): LeadSource
    {
        $explicit = self::text($data['source'] ?? null);

        if ($explicit !== null) {
            $resolved = LeadSource::tryFrom($explicit);

            if ($resolved !== null) {
                return $resolved;
            }
        }

        return LeadSource::fromWordPressForm(self::text($data['form'] ?? null));
    }

    /**
     * Accepts the theme's single `attachment_url`, plus an `attachments` array
     * for forward compatibility. Non-HTTP values are discarded.
     *
     * @return list<string>
     */
    private static function attachmentUrls(array $data): array
    {
        $candidates = [];

        if (isset($data['attachment_url'])) {
            $candidates[] = $data['attachment_url'];
        }

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $entry) {
                // Tolerate both ["url", ...] and [{"url": "..."}, ...].
                $candidates[] = is_array($entry) ? ($entry['url'] ?? null) : $entry;
            }
        }

        $urls = [];

        foreach ($candidates as $candidate) {
            $url = self::text($candidate, 2000);

            if ($url === null || ! preg_match('#^https?://#i', $url)) {
                continue;
            }

            $urls[] = $url;
        }

        return array_values(array_unique($urls));
    }

    /**
     * Trim, collapse empty strings to null, and cap length so an oversized
     * field cannot fail the insert.
     */
    private static function text(mixed $value, int $maxLength = 255): ?string
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return null;
        }

        $trimmed = trim((string) $value);

        if ($trimmed === '') {
            return null;
        }

        return mb_substr($trimmed, 0, $maxLength);
    }

    private static function positiveInt(mixed $value): ?int
    {
        if (! is_numeric($value)) {
            return null;
        }

        $int = (int) $value;

        return $int > 0 ? $int : null;
    }
}
