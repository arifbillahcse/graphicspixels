<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // A key from App\Support\NotificationCatalog.
            $table->string('notification_key');

            $table->boolean('email')->default(false);
            $table->boolean('in_app')->default(true);

            $table->timestamps();

            // A row only exists once somebody changes a setting; absence means
            // "use the catalog default", so duplicates would be ambiguous.
            $table->unique(['user_id', 'notification_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
