<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qc_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('qc_review_id')->constrained()->cascadeOnDelete();

            $table->text('comment');

            // blocker | minor
            $table->string('severity')->default('minor')->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qc_comments');
    }
};
