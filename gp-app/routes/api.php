<?php

use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Support\Facades\Route;

/*
| Inbound webhook from the WordPress site. The theme posts here from
| gp_forward_to_app() in inc/submissions.php with a bearer token.
|
| Throttled generously: the theme already rate-limits per IP, this is a second
| line of defence against a runaway retry loop.
*/
Route::post('/submissions', [SubmissionController::class, 'store'])
    ->middleware(['webhook.token', 'throttle:120,1'])
    ->name('api.submissions.store');
