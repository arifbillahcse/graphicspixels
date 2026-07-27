<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Inbound webhook
    |--------------------------------------------------------------------------
    |
    | Shared secret the WordPress theme sends as "Authorization: Bearer <key>"
    | when forwarding a form submission. Must match GP_APP_API_KEY in the
    | site's wp-config.php. Leaving this empty disables the endpoint outright
    | rather than leaving it unauthenticated.
    |
    */

    'webhook' => [
        'key' => env('GP_APP_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Lead attachments
    |--------------------------------------------------------------------------
    |
    | The theme uploads files into the WordPress media library and sends us the
    | URL, so attachments are copied across asynchronously. The size ceiling
    | mirrors the 25 MB limit the theme enforces on upload.
    |
    */

    'attachments' => [
        'disk' => env('GP_ATTACHMENT_DISK', 'local'),
        'max_bytes' => (int) env('GP_ATTACHMENT_MAX_BYTES', 25 * 1024 * 1024),
        'timeout' => (int) env('GP_ATTACHMENT_TIMEOUT', 30),
    ],

];
