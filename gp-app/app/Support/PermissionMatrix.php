<?php

namespace App\Support;

use App\Enums\RoleName;

/**
 * Single source of truth for what each role may do.
 *
 * Phase 1 only seeds these names and binds them to roles; the leads, orders,
 * batches and QC features that consume them arrive in phases 2-4. Keeping the
 * matrix here (rather than inline in the seeder) means the seeder, the tests
 * and any future admin UI all read the same definition.
 *
 * This class deliberately has no framework dependencies so it can be loaded and
 * asserted against in isolation.
 */
final class PermissionMatrix
{
    /**
     * Every permission in the system, grouped by the feature area it belongs to.
     * The group key is used as a display heading in the roles admin screen.
     */
    public const GROUPS = [
        'Leads' => [
            'leads.view',
            'leads.create',
            'leads.update',
            'leads.delete',
            'leads.assign',
        ],
        'Clients' => [
            'clients.view',
            'clients.manage',
        ],
        'Orders' => [
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.delete',
            'orders.assign',
        ],
        'Batches' => [
            'batches.view',
            'batches.create',
            'batches.assign',
            'batches.update.own',
        ],
        'Quality Control' => [
            'qc.view',
            'qc.approve',
            'qc.reject',
        ],
        'Staff' => [
            'staff.view',
            'staff.manage',
            'staff.workload.view',
        ],
        'Reports' => [
            'reports.view',
            'reports.export',
        ],
        'Settings' => [
            'settings.manage',
        ],
    ];

    /**
     * Permissions granted to each non-admin role. Admin is resolved dynamically
     * in forRole() so newly added permissions are never accidentally withheld
     * from administrators.
     */
    private const ROLE_PERMISSIONS = [
        'marketing_manager' => [
            'leads.view',
            'leads.create',
            'leads.update',
            'leads.assign',
            'clients.view',
            'clients.manage',
            'reports.view',
        ],
        'production_manager' => [
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.delete',
            'orders.assign',
            'batches.view',
            'batches.create',
            'batches.assign',
            'qc.view',
            'clients.view',
            'staff.view',
            'staff.workload.view',
            'reports.view',
            'reports.export',
        ],
        'team_leader' => [
            'orders.view',
            'batches.view',
            'batches.create',
            'batches.assign',
            'qc.view',
            'staff.workload.view',
        ],
        'editor' => [
            'batches.view',
            'batches.update.own',
        ],
        'qc_staff' => [
            'batches.view',
            'qc.view',
            'qc.approve',
            'qc.reject',
        ],
    ];

    /**
     * Flat list of every permission name.
     *
     * @return list<string>
     */
    public static function all(): array
    {
        return array_values(array_unique(array_merge(...array_values(self::GROUPS))));
    }

    /**
     * Permissions for a single role. Admin always receives everything.
     *
     * @return list<string>
     */
    public static function forRole(RoleName $role): array
    {
        if ($role === RoleName::Admin) {
            return self::all();
        }

        return self::ROLE_PERMISSIONS[$role->value] ?? [];
    }

    public static function roleHas(RoleName $role, string $permission): bool
    {
        return in_array($permission, self::forRole($role), true);
    }

    /**
     * Any permission granted to a role that is not declared in GROUPS, i.e. a
     * typo. Should always be empty; asserted in the test suite.
     *
     * @return list<string>
     */
    public static function undefinedPermissions(): array
    {
        $declared = self::all();
        $granted = array_merge(...array_values(self::ROLE_PERMISSIONS));

        return array_values(array_unique(array_diff($granted, $declared)));
    }
}
