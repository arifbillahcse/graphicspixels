<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('type')->default('annual');

            // Inclusive: a single day is starts_on == ends_on.
            $table->date('starts_on');
            $table->date('ends_on');

            $table->text('reason')->nullable();

            // pending | approved | denied | cancelled
            $table->string('status')->default('pending')->index();

            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_note')->nullable();

            $table->timestamps();

            // Availability lookups filter by person, then by whether the range
            // covers a date, so this is the useful composite.
            $table->index(['user_id', 'status', 'starts_on']);
            $table->index(['status', 'starts_on', 'ends_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
