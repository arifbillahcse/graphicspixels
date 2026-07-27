<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authenticates the inbound submissions webhook against the shared secret the
 * WordPress theme sends as a bearer token.
 */
class VerifyWebhookToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('graphicspixels.webhook.key');

        // Refuse rather than run unauthenticated if no key has been configured.
        if ($expected === '') {
            return response()->json([
                'ok' => false,
                'error' => 'Webhook is not configured.',
            ], 503);
        }

        $provided = (string) $request->bearerToken();

        if ($provided === '' || ! hash_equals($expected, $provided)) {
            return response()->json([
                'ok' => false,
                'error' => 'Invalid or missing API key.',
            ], 401);
        }

        return $next($request);
    }
}
