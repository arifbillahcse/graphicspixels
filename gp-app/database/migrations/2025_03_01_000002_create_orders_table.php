<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Human-facing identifier quoted to clients, e.g. GP-2026-0042.
            $table->string('reference')->unique();

            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();

            $table->string('service_type')->index();
            $table->unsignedInteger('image_count');

            // External storage links; the studio works from Drive/Dropbox today,
            // so no upload handling here by design.
            $table->text('file_intake_link')->nullable();
            $table->text('delivery_link')->nullable();

            $table->string('status')->default('received')->index();
            $table->boolean('rush')->default(false)->index();

            // received_at anchors the SLA window; deadline is the promise.
            $table->timestamp('received_at');
            $table->timestamp('deadline')->index();
            $table->timestamp('completed_at')->nullable();

            // The moment this order hits 80% of its SLA window. Stored rather
            // than derived so the "at risk" query stays a plain indexed
            // comparison, and portable across SQLite and MySQL. Recalculated
            // whenever received_at or deadline changes.
            $table->timestamp('risk_at')->nullable()->index();

            // The team leader responsible for delivering the order.
            $table->foreignId('team_leader_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'deadline']);
            $table->index(['team_leader_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
