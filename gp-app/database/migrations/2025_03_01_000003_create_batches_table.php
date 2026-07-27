<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // Sequential within the order: batch 1 of 4, and so on.
            $table->unsignedInteger('batch_number');
            $table->unsignedInteger('image_count');

            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('status')->default('pending')->index();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->unique(['order_id', 'batch_number']);
            $table->index(['editor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
