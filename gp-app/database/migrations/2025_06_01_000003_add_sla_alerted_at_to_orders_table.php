<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // When the at-risk alert was last sent for this order. Without it
            // an hourly SLA check would re-notify the same orders every hour
            // until they ship, and people would stop reading the alerts.
            // Cleared automatically when the deadline moves.
            $table->timestamp('sla_alerted_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['sla_alerted_at']);
            $table->dropColumn('sla_alerted_at');
        });
    }
};
