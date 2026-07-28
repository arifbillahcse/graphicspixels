<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qc_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('batch_id')->constrained()->cascadeOnDelete();

            // The editor whose work is under review, denormalised from the
            // batch so the defect figures survive the batch being reassigned.
            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();

            // pending | approved | rejected
            $table->string('outcome')->default('pending')->index();

            // Which checklist items the reviewer ticked, stored as answered so
            // a later change to the checklist does not rewrite history.
            $table->json('checklist')->nullable();

            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['editor_id', 'completed_at']);
            $table->index(['batch_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qc_reviews');
    }
};
