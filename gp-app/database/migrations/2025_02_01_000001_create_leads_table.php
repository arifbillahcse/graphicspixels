<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->index();
            $table->string('phone')->nullable();

            // The free-trial form collects a website; the contact form collects
            // a company name. Both are nullable so either payload shape fits.
            $table->string('website')->nullable();
            $table->string('company')->nullable();

            $table->string('service')->nullable();
            $table->text('message')->nullable();

            // Optional cloud link (Drive/Dropbox) offered as an alternative to
            // uploading files on the free-trial form.
            $table->text('file_link')->nullable();

            $table->string('status')->default('new')->index();
            $table->string('source')->default('other')->index();

            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            // WordPress post ID of the originating submission. Unique so a
            // retried webhook delivery cannot create a second lead.
            $table->unsignedBigInteger('wp_entry_id')->nullable()->unique();

            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['assigned_to', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
