<?php

namespace App\Support;

/**
 * Works out which Laravel notification channels a given notification should go
 * out on for a given person.
 *
 * Pulled out of the notification classes so the rule is written once and can be
 * asserted directly: an explicit preference always wins over the catalog
 * default, an unknown notification sends nothing at all, and a person who has
 * switched everything off receives nothing rather than falling back to the
 * default.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class ChannelResolver
{
    public const MAIL = 'mail';

    public const DATABASE = 'database';

    /**
     * @param  array{email?:bool,in_app?:bool}|null  $preference  the user's stored
     *                                                            row, or null when they have never changed this setting
     * @return list<string> Laravel channel names
     */
    public static function resolve(string $key, ?array $preference = null): array
    {
        // Never invent delivery for something not in the catalog: a typo in a
        // notification class should send nothing, not mail everybody.
        if (! NotificationCatalog::has($key)) {
            return [];
        }

        $defaults = NotificationCatalog::defaults($key);

        $email = self::flag($preference, 'email', $defaults['email']);
        $inApp = self::flag($preference, 'in_app', $defaults['in_app']);

        $channels = [];

        if ($inApp) {
            $channels[] = self::DATABASE;
        }

        if ($email) {
            $channels[] = self::MAIL;
        }

        return $channels;
    }

    public static function wantsEmail(string $key, ?array $preference = null): bool
    {
        return in_array(self::MAIL, self::resolve($key, $preference), true);
    }

    public static function wantsInApp(string $key, ?array $preference = null): bool
    {
        return in_array(self::DATABASE, self::resolve($key, $preference), true);
    }

    /**
     * A stored preference wins even when it is false; only a missing key falls
     * back to the catalog default.
     */
    private static function flag(?array $preference, string $name, bool $default): bool
    {
        if ($preference === null || ! array_key_exists($name, $preference)) {
            return $default;
        }

        return (bool) $preference[$name];
    }
}
