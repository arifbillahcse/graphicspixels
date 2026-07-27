<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('department')->nullable()->index();
            $table->string('job_title')->nullable();

            // Self-referencing link from an editor to their team leader. Declared
            // as a plain indexed column rather than a constrained foreignId
            // because SQLite cannot add foreign keys to an existing table; the
            // relationship is enforced through the User::teamLeader() relation.
            $table->unsignedBigInteger('team_leader_id')->nullable()->index();

            $table->boolean('is_active')->default(true)->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['department']);
            $table->dropIndex(['team_leader_id']);
            $table->dropIndex(['is_active']);
            $table->dropColumn(['department', 'job_title', 'team_leader_id', 'is_active']);
        });
    }
};
