<?php

namespace App\Console\Commands;

use App\Enums\RoleName;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderAtRisk;
use Illuminate\Console\Command;

/**
 * Alerts production about orders that have passed 80% of their delivery window
 * and are not finished.
 *
 * Each order is alerted once. Without that, an hourly run would re-notify the
 * same orders every hour until they ship and people would stop reading the
 * alerts entirely. Moving an order's deadline clears the marker, so a
 * renegotiated job earns a fresh warning.
 */
class CheckOrderSla extends Command
{
    protected $signature = 'orders:check-sla {--dry-run : List what would be sent without notifying anyone}';

    protected $description = 'Notify production about orders close to breaching their delivery deadline';

    public function handle(): int
    {
        $orders = Order::atRisk()
            ->whereNull('sla_alerted_at')
            ->with(['client', 'teamLeader'])
            ->orderBy('deadline')
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No orders are newly at risk.');

            return self::SUCCESS;
        }

        $managers = User::role(RoleName::ProductionManager->value)
            ->where('is_active', true)
            ->get();

        $dryRun = (bool) $this->option('dry-run');
        $sent = 0;

        foreach ($orders as $order) {
            // The responsible team leader as well as production management —
            // they are the person who can actually do something about it.
            $recipients = $managers
                ->concat($order->teamLeader ? [$order->teamLeader] : [])
                ->unique('id');

            $this->line(sprintf(
                '%s  %-22s %s  -> %d recipient%s',
                $order->reference,
                mb_substr((string) $order->client?->displayName(), 0, 22),
                $order->sla()->label(),
                $recipients->count(),
                $recipients->count() === 1 ? '' : 's',
            ));

            if ($dryRun) {
                continue;
            }

            foreach ($recipients as $recipient) {
                $recipient->notify(new OrderAtRisk($order));
            }

            $order->forceFill(['sla_alerted_at' => now()])->saveQuietly();
            $sent++;
        }

        $this->info($dryRun
            ? "{$orders->count()} orders would be alerted."
            : "Alerted on {$sent} order".($sent === 1 ? '' : 's').'.');

        return self::SUCCESS;
    }
}
