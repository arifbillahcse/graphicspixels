<?php

namespace App\Enums;

/**
 * Roles map one-to-one onto the Spatie role records seeded by
 * Database\Seeders\RolePermissionSeeder. The enum value is the stored role name.
 */
enum RoleName: string
{
    case Admin = 'admin';
    case MarketingManager = 'marketing_manager';
    case ProductionManager = 'production_manager';
    case TeamLeader = 'team_leader';
    case Editor = 'editor';
    case QcStaff = 'qc_staff';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::MarketingManager => 'Marketing Manager',
            self::ProductionManager => 'Production Manager',
            self::TeamLeader => 'Team Leader',
            self::Editor => 'Editor',
            self::QcStaff => 'QC Staff',
        };
    }

    public function department(): Department
    {
        return match ($this) {
            self::Admin => Department::Administration,
            self::MarketingManager => Department::Marketing,
            self::ProductionManager, self::TeamLeader, self::Editor => Department::Production,
            self::QcStaff => Department::QualityControl,
        };
    }

    /**
     * Named route each role lands on after logging in.
     */
    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Admin => 'dashboard.admin',
            self::MarketingManager => 'dashboard.marketing',
            self::ProductionManager => 'dashboard.production',
            self::TeamLeader => 'dashboard.team',
            self::Editor => 'dashboard.editor',
            self::QcStaff => 'dashboard.qc',
        };
    }
}
