<?php

namespace App\Enums;

/**
 * Where a lead came from. The WordPress theme identifies the originating form
 * with a human-readable label rather than a slug, so fromWordPressForm() maps
 * those labels onto this enum.
 *
 * @see graphicspixels-theme/inc/submissions.php on the wp-graphicspixels branch
 */
enum LeadSource: string
{
    case FreeTrial = 'free_trial';
    case Contact = 'contact';
    case Manual = 'manual';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::FreeTrial => 'Free Trial',
            self::Contact => 'Contact Form',
            self::Manual => 'Added Manually',
            self::Other => 'Other',
        };
    }

    /**
     * Labels sent by the theme in the payload's "form" field.
     */
    public static function fromWordPressForm(?string $form): self
    {
        return match (trim((string) $form)) {
            'Free Trial Request' => self::FreeTrial,
            'Contact Message' => self::Contact,
            default => self::Other,
        };
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $s) => $s->value, self::cases());
    }
}
