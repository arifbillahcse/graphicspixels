<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| Hourly is frequent enough for a 24-hour SLA: an order crosses the 80% mark
| roughly five hours before its deadline, which leaves room to act. The command
| only alerts each order once, so running it more often would not spam anyone —
| it would just find nothing to do.
|
| Requires a scheduler entry on the server:
|   * * * * * cd /path-to-app && php artisan schedule:run >> /dev/null 2>&1
*/
Schedule::command('orders:check-sla')
    ->hourly()
    ->withoutOverlapping();
