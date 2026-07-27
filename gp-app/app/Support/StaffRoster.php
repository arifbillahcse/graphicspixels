<?php

namespace App\Support;

use App\Enums\RoleName;

/**
 * The development staff roster seeded by Database\Seeders\UserSeeder:
 * 1 admin, 2 marketing managers, 2 production managers, 3 team leaders,
 * 5 editors and 2 QC staff.
 *
 * Names mirror the departments published on the public about page so seeded
 * data reads like the real organisation. Kept separate from the seeder, and
 * free of framework dependencies, so the roster can be asserted against
 * directly in tests.
 */
final class StaffRoster
{
    /**
     * @return list<array{name:string,email:string,job_title:string,role:RoleName,team_leader_email:?string}>
     */
    public static function all(): array
    {
        return [
            // Administration
            [
                'name' => 'Ajijul Haque',
                'email' => 'admin@graphicspixels.test',
                'job_title' => 'Managing Director',
                'role' => RoleName::Admin,
                'team_leader_email' => null,
            ],

            // Marketing
            [
                'name' => 'David Joy',
                'email' => 'marketing1@graphicspixels.test',
                'job_title' => 'Head of Marketing',
                'role' => RoleName::MarketingManager,
                'team_leader_email' => null,
            ],
            [
                'name' => 'MD. Sahab Uddin',
                'email' => 'marketing2@graphicspixels.test',
                'job_title' => 'Marketing Manager',
                'role' => RoleName::MarketingManager,
                'team_leader_email' => null,
            ],

            // Production management
            [
                'name' => 'Omar Faruk',
                'email' => 'production1@graphicspixels.test',
                'job_title' => 'Production Manager',
                'role' => RoleName::ProductionManager,
                'team_leader_email' => null,
            ],
            [
                'name' => 'Muntasir Mahmud Chowdhury',
                'email' => 'production2@graphicspixels.test',
                'job_title' => 'General Manager, Production',
                'role' => RoleName::ProductionManager,
                'team_leader_email' => null,
            ],

            // Team leaders
            [
                'name' => 'Al-Amin',
                'email' => 'lead1@graphicspixels.test',
                'job_title' => 'Team Leader',
                'role' => RoleName::TeamLeader,
                'team_leader_email' => null,
            ],
            [
                'name' => 'Md Sojib Alam',
                'email' => 'lead2@graphicspixels.test',
                'job_title' => 'Team Leader',
                'role' => RoleName::TeamLeader,
                'team_leader_email' => null,
            ],
            [
                'name' => 'Tariqul Islam',
                'email' => 'lead3@graphicspixels.test',
                'job_title' => 'Team Leader',
                'role' => RoleName::TeamLeader,
                'team_leader_email' => null,
            ],

            // Editors
            [
                'name' => 'Mushlay Uddin Himel',
                'email' => 'editor1@graphicspixels.test',
                'job_title' => 'Photo Editor',
                'role' => RoleName::Editor,
                'team_leader_email' => 'lead1@graphicspixels.test',
            ],
            [
                'name' => 'Rakib Hasan',
                'email' => 'editor2@graphicspixels.test',
                'job_title' => 'Photo Editor',
                'role' => RoleName::Editor,
                'team_leader_email' => 'lead1@graphicspixels.test',
            ],
            [
                'name' => 'Nayeem Islam',
                'email' => 'editor3@graphicspixels.test',
                'job_title' => 'Photo Editor',
                'role' => RoleName::Editor,
                'team_leader_email' => 'lead2@graphicspixels.test',
            ],
            [
                'name' => 'Shakil Ahmed',
                'email' => 'editor4@graphicspixels.test',
                'job_title' => 'Retoucher',
                'role' => RoleName::Editor,
                'team_leader_email' => 'lead2@graphicspixels.test',
            ],
            [
                'name' => 'Jubayer Alam',
                'email' => 'editor5@graphicspixels.test',
                'job_title' => 'Retoucher',
                'role' => RoleName::Editor,
                'team_leader_email' => 'lead3@graphicspixels.test',
            ],

            // Quality control
            [
                'name' => 'Forhad Hossain Fahim',
                'email' => 'qc1@graphicspixels.test',
                'job_title' => 'QC Specialist',
                'role' => RoleName::QcStaff,
                'team_leader_email' => null,
            ],
            [
                'name' => 'Md. Reyaj Hassan',
                'email' => 'qc2@graphicspixels.test',
                'job_title' => 'QC Specialist',
                'role' => RoleName::QcStaff,
                'team_leader_email' => null,
            ],
        ];
    }
}
