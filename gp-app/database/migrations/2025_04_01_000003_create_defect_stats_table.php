<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('defect_stats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('editor_id')->constrained('users')->cascadeOnDelete();

            // Calendar month as YYYY-MM. One row per editor per month, kept up
            // to date as reviews complete rather than by a nightly job, so the
            // dashboard is never a day behind.
            $table->string('period', 7)->index();

            $table->unsignedInteger('total_reviews')->default(0);
            $table->unsignedInteger('rejected_count')->default(0);
            $table->decimal('reject_rate', 5, 1)->default(0);

            $table->timestamps();

            $table->unique(['editor_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('defect_stats');
    }
};
