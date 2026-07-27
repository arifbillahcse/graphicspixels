<?php

namespace Tests\Feature;

use App\Enums\RoleName;
use App\Models\User;
use App\Support\PermissionMatrix;
use App\Support\StaffRoster;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Seeded account for each role, and the dashboard it must land on.
     */
    private const ROLE_LANDING = [
        'admin@graphicspixels.test' => 'dashboard.admin',
        'marketing1@graphicspixels.test' => 'dashboard.marketing',
        'production1@graphicspixels.test' => 'dashboard.production',
        'lead1@graphicspixels.test' => 'dashboard.team',
        'editor1@graphicspixels.test' => 'dashboard.editor',
        'qc1@graphicspixels.test' => 'dashboard.qc',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolePermissionSeeder::class, UserSeeder::class]);
    }

    private function user(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_each_role_lands_on_its_own_dashboard(): void
    {
        foreach (self::ROLE_LANDING as $email => $route) {
            $this->actingAs($this->user($email))
                ->get('/dashboard')
                ->assertRedirect(route($route));
        }
    }

    public function test_each_role_can_open_its_own_dashboard(): void
    {
        foreach (self::ROLE_LANDING as $email => $route) {
            $this->actingAs($this->user($email))
                ->get(route($route))
                ->assertOk();
        }
    }

    public function test_admin_can_reach_every_dashboard(): void
    {
        $admin = $this->user('admin@graphicspixels.test');

        foreach (self::ROLE_LANDING as $route) {
            $this->actingAs($admin)->get(route($route))->assertOk();
        }
    }

    public function test_editor_cannot_reach_other_dashboards(): void
    {
        $editor = $this->user('editor1@graphicspixels.test');

        foreach (self::ROLE_LANDING as $route) {
            if ($route === 'dashboard.editor') {
                continue;
            }

            $this->actingAs($editor)->get(route($route))->assertForbidden();
        }
    }

    public function test_qc_staff_cannot_reach_production_dashboard(): void
    {
        $this->actingAs($this->user('qc1@graphicspixels.test'))
            ->get(route('dashboard.production'))
            ->assertForbidden();
    }

    public function test_marketing_cannot_reach_admin_dashboard(): void
    {
        $this->actingAs($this->user('marketing1@graphicspixels.test'))
            ->get(route('dashboard.admin'))
            ->assertForbidden();
    }

    public function test_permission_matrix_has_no_undefined_permissions(): void
    {
        $this->assertSame([], PermissionMatrix::undefinedPermissions());
    }

    public function test_every_permission_is_seeded(): void
    {
        $this->assertDatabaseCount('permissions', count(PermissionMatrix::all()));
        $this->assertDatabaseCount('roles', count(RoleName::cases()));
    }

    public function test_admin_holds_every_permission(): void
    {
        $admin = $this->user('admin@graphicspixels.test');

        foreach (PermissionMatrix::all() as $permission) {
            $this->assertTrue(
                $admin->can($permission),
                "Admin is missing permission [{$permission}]",
            );
        }
    }

    public function test_editor_holds_only_its_own_batch_permissions(): void
    {
        $editor = $this->user('editor1@graphicspixels.test');

        $this->assertTrue($editor->can('batches.view'));
        $this->assertTrue($editor->can('batches.update.own'));

        $this->assertFalse($editor->can('orders.create'));
        $this->assertFalse($editor->can('leads.view'));
        $this->assertFalse($editor->can('qc.approve'));
        $this->assertFalse($editor->can('settings.manage'));
    }

    public function test_qc_staff_can_approve_but_not_create_orders(): void
    {
        $qc = $this->user('qc1@graphicspixels.test');

        $this->assertTrue($qc->can('qc.approve'));
        $this->assertTrue($qc->can('qc.reject'));
        $this->assertFalse($qc->can('orders.create'));
        $this->assertFalse($qc->can('leads.view'));
    }

    public function test_marketing_manager_owns_leads_but_not_production(): void
    {
        $marketing = $this->user('marketing1@graphicspixels.test');

        $this->assertTrue($marketing->can('leads.create'));
        $this->assertTrue($marketing->can('clients.manage'));
        $this->assertFalse($marketing->can('orders.create'));
        $this->assertFalse($marketing->can('qc.approve'));
    }

    public function test_production_manager_runs_orders_but_not_settings(): void
    {
        $production = $this->user('production1@graphicspixels.test');

        $this->assertTrue($production->can('orders.create'));
        $this->assertTrue($production->can('batches.assign'));
        $this->assertTrue($production->can('reports.export'));
        $this->assertFalse($production->can('settings.manage'));
        $this->assertFalse($production->can('leads.create'));
    }

    public function test_roster_is_seeded_with_expected_distribution(): void
    {
        $this->assertDatabaseCount('users', count(StaffRoster::all()));

        $expected = [
            RoleName::Admin->value => 1,
            RoleName::MarketingManager->value => 2,
            RoleName::ProductionManager->value => 2,
            RoleName::TeamLeader->value => 3,
            RoleName::Editor->value => 5,
            RoleName::QcStaff->value => 2,
        ];

        foreach ($expected as $role => $count) {
            $this->assertCount(
                $count,
                User::role($role)->get(),
                "Expected {$count} users with role [{$role}]",
            );
        }
    }

    public function test_editors_report_to_a_team_leader(): void
    {
        $editors = User::role(RoleName::Editor->value)->get();

        $this->assertCount(5, $editors);

        foreach ($editors as $editor) {
            $this->assertNotNull(
                $editor->teamLeader,
                "Editor [{$editor->email}] has no team leader",
            );
            $this->assertTrue(
                $editor->teamLeader->hasRole(RoleName::TeamLeader->value),
                "Editor [{$editor->email}] reports to a non-team-leader",
            );
        }
    }

    public function test_user_department_matches_their_role(): void
    {
        foreach (StaffRoster::all() as $row) {
            $user = $this->user($row['email']);

            $this->assertSame(
                $row['role']->department(),
                $user->department,
                "Wrong department for [{$row['email']}]",
            );
        }
    }
}
