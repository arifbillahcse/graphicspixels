<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();

            // Null when the entry was recorded by the system, e.g. by the
            // incoming webhook rather than a member of staff.
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('action')->index();
            $table->text('note')->nullable();

            // Structured detail for the entry, e.g. {"from":"new","to":"contacted"}.
            $table->json('properties')->nullable();

            $table->timestamps();

            $table->index(['lead_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_activities');
    }
};
