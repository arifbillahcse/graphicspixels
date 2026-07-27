<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // Set when the note is about one specific batch rather than the
            // order as a whole, which is how editors log progress.
            $table->foreignId('batch_id')->nullable()->constrained()->cascadeOnDelete();

            // Null for entries written by the system rather than a person.
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->text('note');
            $table->timestamps();

            $table->index(['order_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_notes');
    }
};
