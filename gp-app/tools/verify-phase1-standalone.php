<?php

/**
 * Phase 1 verification harness.
 *
 * Composer is blocked in this environment, so Laravel itself cannot boot.
 * Instead this loads the framework-independent Phase 1 classes directly and
 * executes the real schema + seed logic against a live SQLite database via PDO,
 * then asserts the role/permission matrix resolves correctly with SQL joins.
 *
 * It exercises the ACTUAL application classes (PermissionMatrix, StaffRoster,
 * RoleName, Department) - not copies - so a mistake in them fails this run.
 */

$appRoot = dirname(__DIR__);

require $appRoot.'/app/Enums/Department.php';
require $appRoot.'/app/Enums/RoleName.php';
require $appRoot.'/app/Support/PermissionMatrix.php';
require $appRoot.'/app/Support/StaffRoster.php';

use App\Enums\RoleName;
use App\Support\PermissionMatrix;
use App\Support\StaffRoster;

$pass = 0;
$fail = 0;
$failures = [];

function check(string $label, bool $ok, string $detail = ''): void
{
    global $pass, $fail, $failures;

    if ($ok) {
        $pass++;
        echo "  PASS  {$label}\n";
    } else {
        $fail++;
        $failures[] = $label.($detail ? " -- {$detail}" : '');
        echo "  FAIL  {$label}".($detail ? " -- {$detail}" : '')."\n";
    }
}

function section(string $title): void
{
    echo "\n== {$title} ==\n";
}

// ---------------------------------------------------------------------------
// Build the schema exactly as the migrations declare it.
// ---------------------------------------------------------------------------

$db = new PDO('sqlite::memory:');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = ON');

// Laravel's stock users table (0001_01_01_000000_create_users_table.php)
// plus the columns added by 2025_01_01_000001_add_staff_fields_to_users_table.php
$db->exec(<<<'SQL'
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    email_verified_at DATETIME NULL,
    password VARCHAR NOT NULL,
    remember_token VARCHAR NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    department VARCHAR NULL,
    job_title VARCHAR NULL,
    team_leader_id INTEGER NULL,
    is_active TINYINT NOT NULL DEFAULT 1
)
SQL);
$db->exec('CREATE UNIQUE INDEX users_email_unique ON users (email)');
$db->exec('CREATE INDEX users_department_index ON users (department)');
$db->exec('CREATE INDEX users_team_leader_id_index ON users (team_leader_id)');
$db->exec('CREATE INDEX users_is_active_index ON users (is_active)');

// Spatie permission tables (create_permission_tables.php.stub, teams disabled)
$db->exec(<<<'SQL'
CREATE TABLE permissions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    guard_name VARCHAR NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    UNIQUE (name, guard_name)
)
SQL);

$db->exec(<<<'SQL'
CREATE TABLE roles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    guard_name VARCHAR NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    UNIQUE (name, guard_name)
)
SQL);

$db->exec(<<<'SQL'
CREATE TABLE model_has_roles (
    role_id INTEGER NOT NULL,
    model_type VARCHAR NOT NULL,
    model_id INTEGER NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
)
SQL);

$db->exec(<<<'SQL'
CREATE TABLE role_has_permissions (
    permission_id INTEGER NOT NULL,
    role_id INTEGER NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
)
SQL);

echo "Schema created.\n";

// ---------------------------------------------------------------------------
// Replay RolePermissionSeeder using the real PermissionMatrix.
// ---------------------------------------------------------------------------

section('Permission matrix integrity');

check(
    'No role grants a permission missing from GROUPS (typo check)',
    PermissionMatrix::undefinedPermissions() === [],
    implode(', ', PermissionMatrix::undefinedPermissions()),
);

$allPermissions = PermissionMatrix::all();
check('Permission names are unique', count($allPermissions) === count(array_unique($allPermissions)));

$insPerm = $db->prepare('INSERT INTO permissions (name, guard_name) VALUES (?, ?)');
foreach ($allPermissions as $p) {
    $insPerm->execute([$p, 'web']);
}

$insRole = $db->prepare('INSERT INTO roles (name, guard_name) VALUES (?, ?)');
$insRolePerm = $db->prepare(
    'INSERT INTO role_has_permissions (permission_id, role_id)
     VALUES ((SELECT id FROM permissions WHERE name = ? AND guard_name = ?), ?)'
);

foreach (RoleName::cases() as $role) {
    $insRole->execute([$role->value, 'web']);
    $roleId = (int) $db->lastInsertId();

    foreach (PermissionMatrix::forRole($role) as $permission) {
        $insRolePerm->execute([$permission, 'web', $roleId]);
    }
}

$permCount = (int) $db->query('SELECT COUNT(*) FROM permissions')->fetchColumn();
$roleCount = (int) $db->query('SELECT COUNT(*) FROM roles')->fetchColumn();

check("permissions table seeded ({$permCount} rows)", $permCount === count($allPermissions));
check("roles table seeded ({$roleCount} rows)", $roleCount === 6, 'expected 6 roles');

// ---------------------------------------------------------------------------
// Assert the matrix through SQL, the way the app will actually query it.
// ---------------------------------------------------------------------------

section('Role capability checks (resolved via SQL joins)');

$roleHas = $db->prepare(
    'SELECT COUNT(*) FROM roles r
     JOIN role_has_permissions rhp ON rhp.role_id = r.id
     JOIN permissions p ON p.id = rhp.permission_id
     WHERE r.name = ? AND p.name = ?'
);

function can(PDO $db, PDOStatement $stmt, string $role, string $permission): bool
{
    $stmt->execute([$role, $permission]);

    return (int) $stmt->fetchColumn() > 0;
}

// Admin must hold every permission, including ones added later.
$adminCount = (int) $db->query(
    "SELECT COUNT(*) FROM roles r
     JOIN role_has_permissions rhp ON rhp.role_id = r.id
     WHERE r.name = 'admin'"
)->fetchColumn();
check("Admin holds every permission ({$adminCount}/{$permCount})", $adminCount === $permCount);

// Positive grants
check('Marketing Manager can leads.create', can($db, $roleHas, 'marketing_manager', 'leads.create'));
check('Marketing Manager can clients.manage', can($db, $roleHas, 'marketing_manager', 'clients.manage'));
check('Production Manager can orders.create', can($db, $roleHas, 'production_manager', 'orders.create'));
check('Production Manager can batches.assign', can($db, $roleHas, 'production_manager', 'batches.assign'));
check('Production Manager can reports.export', can($db, $roleHas, 'production_manager', 'reports.export'));
check('Team Leader can batches.create', can($db, $roleHas, 'team_leader', 'batches.create'));
check('Team Leader can batches.assign', can($db, $roleHas, 'team_leader', 'batches.assign'));
check('Editor can batches.update.own', can($db, $roleHas, 'editor', 'batches.update.own'));
check('QC Staff can qc.approve', can($db, $roleHas, 'qc_staff', 'qc.approve'));
check('QC Staff can qc.reject', can($db, $roleHas, 'qc_staff', 'qc.reject'));

// Negative grants - these are the ones that matter for least privilege.
check('Editor CANNOT orders.create', ! can($db, $roleHas, 'editor', 'orders.create'));
check('Editor CANNOT leads.view', ! can($db, $roleHas, 'editor', 'leads.view'));
check('Editor CANNOT qc.approve', ! can($db, $roleHas, 'editor', 'qc.approve'));
check('Editor CANNOT settings.manage', ! can($db, $roleHas, 'editor', 'settings.manage'));
check('QC Staff CANNOT orders.create', ! can($db, $roleHas, 'qc_staff', 'orders.create'));
check('QC Staff CANNOT leads.view', ! can($db, $roleHas, 'qc_staff', 'leads.view'));
check('Marketing Manager can orders.create (raises the order they won)', can($db, $roleHas, 'marketing_manager', 'orders.create'));
check('Marketing Manager CANNOT orders.assign', ! can($db, $roleHas, 'marketing_manager', 'orders.assign'));
check('Marketing Manager CANNOT batches.create', ! can($db, $roleHas, 'marketing_manager', 'batches.create'));
check('Marketing Manager CANNOT qc.approve', ! can($db, $roleHas, 'marketing_manager', 'qc.approve'));
check('Team Leader CANNOT orders.create', ! can($db, $roleHas, 'team_leader', 'orders.create'));
check('Team Leader CANNOT staff.manage', ! can($db, $roleHas, 'team_leader', 'staff.manage'));
check('Production Manager CANNOT settings.manage', ! can($db, $roleHas, 'production_manager', 'settings.manage'));
check('Production Manager CANNOT leads.create', ! can($db, $roleHas, 'production_manager', 'leads.create'));

// Editor is the tightest role; pin its exact grant set.
$editorPerms = $db->query(
    "SELECT p.name FROM roles r
     JOIN role_has_permissions rhp ON rhp.role_id = r.id
     JOIN permissions p ON p.id = rhp.permission_id
     WHERE r.name = 'editor' ORDER BY p.name"
)->fetchAll(PDO::FETCH_COLUMN);
check(
    'Editor grant set is exactly [batches.update.own, batches.view]',
    $editorPerms === ['batches.update.own', 'batches.view'],
    'got: '.implode(', ', $editorPerms),
);

// ---------------------------------------------------------------------------
// Replay UserSeeder using the real StaffRoster.
// ---------------------------------------------------------------------------

section('Staff roster seeding');

$roster = StaffRoster::all();

$insUser = $db->prepare(
    'INSERT INTO users (name, email, password, department, job_title, is_active, email_verified_at, created_at, updated_at)
     VALUES (?, ?, ?, ?, ?, 1, datetime("now"), datetime("now"), datetime("now"))'
);
$assignRole = $db->prepare(
    'INSERT INTO model_has_roles (role_id, model_type, model_id)
     VALUES ((SELECT id FROM roles WHERE name = ? AND guard_name = "web"), ?, ?)'
);

foreach ($roster as $row) {
    /** @var RoleName $role */
    $role = $row['role'];

    $insUser->execute([
        $row['name'],
        $row['email'],
        password_hash('password', PASSWORD_BCRYPT),
        $role->department()->value,
        $row['job_title'],
    ]);

    $assignRole->execute([$role->value, 'App\\Models\\User', (int) $db->lastInsertId()]);
}

// Second pass: link editors to their team leaders, mirroring UserSeeder.
$linkLeader = $db->prepare(
    'UPDATE users SET team_leader_id = (SELECT id FROM users WHERE email = ?) WHERE email = ?'
);
foreach ($roster as $row) {
    if ($row['team_leader_email'] === null) {
        continue;
    }
    $linkLeader->execute([$row['team_leader_email'], $row['email']]);
}

$userCount = (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn();
check("15 staff accounts seeded (got {$userCount})", $userCount === 15);

$distinctEmails = (int) $db->query('SELECT COUNT(DISTINCT email) FROM users')->fetchColumn();
check('All emails unique', $distinctEmails === $userCount);

// Role distribution must match the Phase 1 spec.
$expectedDistribution = [
    'admin' => 1,
    'marketing_manager' => 2,
    'production_manager' => 2,
    'team_leader' => 3,
    'editor' => 5,
    'qc_staff' => 2,
];

$actual = [];
$rows = $db->query(
    'SELECT r.name AS role, COUNT(*) AS n FROM model_has_roles mhr
     JOIN roles r ON r.id = mhr.role_id GROUP BY r.name'
)->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    $actual[$r['role']] = (int) $r['n'];
}
ksort($actual);
ksort($expectedDistribution);

check(
    'Role distribution is 1 admin / 2 marketing / 2 production / 3 leads / 5 editors / 2 QC',
    $actual === $expectedDistribution,
    'got: '.json_encode($actual),
);

check(
    'Every user has exactly one role',
    (int) $db->query('SELECT COUNT(*) FROM model_has_roles')->fetchColumn() === 15,
);

// Department must match the role's declared department for every user.
$deptMismatches = [];
foreach ($roster as $row) {
    /** @var RoleName $role */
    $role = $row['role'];
    $stored = $db->query(
        'SELECT department FROM users WHERE email = '.$db->quote($row['email'])
    )->fetchColumn();

    if ($stored !== $role->department()->value) {
        $deptMismatches[] = "{$row['email']}: {$stored} != {$role->department()->value}";
    }
}
check('Department matches role for all 15 users', $deptMismatches === [], implode('; ', $deptMismatches));

section('Team structure');

$editorsWithoutLeader = (int) $db->query(
    "SELECT COUNT(*) FROM users u
     JOIN model_has_roles mhr ON mhr.model_id = u.id
     JOIN roles r ON r.id = mhr.role_id
     WHERE r.name = 'editor' AND u.team_leader_id IS NULL"
)->fetchColumn();
check('All 5 editors are linked to a team leader', $editorsWithoutLeader === 0, "{$editorsWithoutLeader} unlinked");

$badLeaderLinks = (int) $db->query(
    "SELECT COUNT(*) FROM users u
     JOIN users l ON l.id = u.team_leader_id
     JOIN model_has_roles mhr ON mhr.model_id = l.id
     JOIN roles r ON r.id = mhr.role_id
     WHERE u.team_leader_id IS NOT NULL AND r.name != 'team_leader'"
)->fetchColumn();
check('Every team_leader_id points at an actual team leader', $badLeaderLinks === 0);

$nonEditorsWithLeader = (int) $db->query(
    "SELECT COUNT(*) FROM users u
     JOIN model_has_roles mhr ON mhr.model_id = u.id
     JOIN roles r ON r.id = mhr.role_id
     WHERE r.name != 'editor' AND u.team_leader_id IS NOT NULL"
)->fetchColumn();
check('Non-editors have no team leader set', $nonEditorsWithLeader === 0);

$orphanLeaders = (int) $db->query(
    'SELECT COUNT(*) FROM users u
     WHERE u.team_leader_id IS NOT NULL
       AND NOT EXISTS (SELECT 1 FROM users l WHERE l.id = u.team_leader_id)'
)->fetchColumn();
check('No editor points at a non-existent leader', $orphanLeaders === 0);

// ---------------------------------------------------------------------------
// Enum routing sanity.
// ---------------------------------------------------------------------------

section('Role routing');

$routes = array_map(fn (RoleName $r) => $r->dashboardRoute(), RoleName::cases());
check('Each role maps to a distinct dashboard route', count($routes) === count(array_unique($routes)));
check('Six roles defined', count(RoleName::cases()) === 6);

$departments = array_unique(array_map(fn (RoleName $r) => $r->department()->value, RoleName::cases()));
sort($departments);
check(
    'Roles span all four departments',
    $departments === ['administration', 'marketing', 'production', 'quality_control'],
    implode(', ', $departments),
);

// ---------------------------------------------------------------------------

echo "\n".str_repeat('-', 60)."\n";
echo "RESULT: {$pass} passed, {$fail} failed\n";
if ($failures) {
    echo "\nFailures:\n";
    foreach ($failures as $f) {
        echo "  - {$f}\n";
    }
}
echo str_repeat('-', 60)."\n";

exit($fail === 0 ? 0 : 1);
