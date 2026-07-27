<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use App\Support\StaffRoster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeds the development staff accounts defined in App\Support\StaffRoster.
 * Every account uses DEFAULT_PASSWORD. Idempotent: re-running updates the
 * existing accounts rather than duplicating them.
 */
class UserSeeder extends Seeder
{
    public const DEFAULT_PASSWORD = 'password';

    public function run(): void
    {
        foreach (StaffRoster::all() as $row) {
            /** @var RoleName $role */
            $role = $row['role'];

            $user = User::updateOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['name'],
                    'password' => Hash::make(self::DEFAULT_PASSWORD),
                    'department' => $role->department(),
                    'job_title' => $row['job_title'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
            );

            $user->syncRoles([$role->value]);
        }

        // Second pass: editors can only be linked once their team leader exists.
        foreach (StaffRoster::all() as $row) {
            if ($row['team_leader_email'] === null) {
                continue;
            }

            $leaderId = User::where('email', $row['team_leader_email'])->value('id');

            User::where('email', $row['email'])->update(['team_leader_id' => $leaderId]);
        }
    }
}
