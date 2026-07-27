<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles and permissions must exist before users can be assigned to them.
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
