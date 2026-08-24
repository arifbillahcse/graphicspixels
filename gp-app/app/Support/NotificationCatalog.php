<?php

namespace App\Support;

/**
 * Every notification the platform can send, and how it behaves by default.
 *
 * Kept in one place so the preferences screen, the notification classes and the
 * tests all read the same list — adding a notification means adding it here and
 * it appears in the settings UI automatically.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class NotificationCatalog
{
    public const CHANNEL_EMAIL = 'email';

    public const CHANNEL_IN_APP = 'in_app';

    /**
     * key => [label, description, group, email, in_app]
     *
     * The two booleans are the defaults applied when a user has expressed no
     * preference. Anything that interrupts somebody's day (rework coming back,
     * a deadline about to slip) defaults to email as well as in-app; routine
     * assignment notices default to in-app only, so the studio does not drown
     * in mail at 10,000 images a day.
     *
     * @var array<string,array{label:string,description:string,group:string,email:bool,in_app:bool}>
     */
    private const TYPES = [
        'lead.assigned' => [
            'label' => 'Lead assigned to me',
            'description' => 'Someone hands you a lead from the pipeline.',
            'group' => 'Leads',
            'email' => false,
            'in_app' => true,
        ],
        'order.created' => [
            'label' => 'New order raised',
            'description' => 'A won lead is converted into a production order.',
            'group' => 'Production',
            'email' => false,
            'in_app' => true,
        ],
        'order.assigned' => [
            'label' => 'Order assigned to my team',
            'description' => 'Production hands your team an order to deliver.',
            'group' => 'Production',
            'email' => true,
            'in_app' => true,
        ],
        'order.at_risk' => [
            'label' => 'Order at risk of breaching SLA',
            'description' => 'An order has passed 80% of its delivery window and is not finished.',
            'group' => 'Production',
            'email' => true,
            'in_app' => true,
        ],
        'batch.assigned' => [
            'label' => 'Batch assigned to me',
            'description' => 'A batch of images lands in your queue.',
            'group' => 'My work',
            'email' => false,
            'in_app' => true,
        ],
        'batch.rejected' => [
            'label' => 'QC sent my batch back',
            'description' => 'Quality control rejected your work and asked for changes.',
            'group' => 'My work',
            'email' => true,
            'in_app' => true,
        ],
        'leave.decided' => [
            'label' => 'My leave request was decided',
            'description' => 'A manager approved or denied leave you asked for.',
            'group' => 'Me',
            'email' => true,
            'in_app' => true,
        ],
    ];

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return array_keys(self::TYPES);
    }

    public static function has(string $key): bool
    {
        return isset(self::TYPES[$key]);
    }

    /**
     * @return array{label:string,description:string,group:string,email:bool,in_app:bool}|null
     */
    public static function get(string $key): ?array
    {
        return self::TYPES[$key] ?? null;
    }

    public static function label(string $key): string
    {
        return self::TYPES[$key]['label'] ?? $key;
    }

    public static function description(string $key): string
    {
        return self::TYPES[$key]['description'] ?? '';
    }

    /**
     * Default channel switches for a key, as stored on a preference row.
     *
     * @return array{email:bool,in_app:bool}
     */
    public static function defaults(string $key): array
    {
        $type = self::TYPES[$key] ?? null;

        // An unknown key must not silently default to sending mail.
        return [
            'email' => $type['email'] ?? false,
            'in_app' => $type['in_app'] ?? false,
        ];
    }

    /**
     * The catalog arranged for the preferences screen.
     *
     * @return array<string,array<string,array{label:string,description:string,group:string,email:bool,in_app:bool}>>
     */
    public static function grouped(): array
    {
        $grouped = [];

        foreach (self::TYPES as $key => $type) {
            $grouped[$type['group']][$key] = $type;
        }

        return $grouped;
    }
}
