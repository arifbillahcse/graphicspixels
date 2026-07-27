# GraphicsPixels Operations Platform — Phase 1 (Foundation)

Internal management application for GraphicsPixels: leads and client onboarding,
production workflow, quality control, and team management.

Phase 1 delivers **only the foundation** — authentication, roles, permissions,
the staff schema, and role-aware dashboard shells. Leads, orders, batches and QC
arrive in phases 2–4.

---

## ⚠️ Read this first

The files in this directory are an **overlay**, not a complete Laravel app. The
environment they were written in has Composer and npm blocked by network policy,
so the framework itself could not be installed. You need to scaffold Laravel and
apply this overlay on top.

Everything here was verified as far as it can be without the framework — see
[Verification status](#verification-status) for exactly what was and wasn't
proven.

---

## Installation

Run the scaffold steps **first**, then apply this overlay **last** so its files
win (Breeze publishes its own `routes/web.php` and `layouts/app.blade.php`,
which this overlay intentionally replaces).

```bash
# 1. Scaffold Laravel 11 somewhere temporary
composer create-project laravel/laravel:^11.0 /tmp/gp-scaffold
cd /tmp/gp-scaffold

# 2. Auth scaffolding
composer require laravel/breeze --dev
php artisan breeze:install blade

# 3. Roles and permissions
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# 4. Copy the scaffold into this directory WITHOUT clobbering the overlay
cp -rn /tmp/gp-scaffold/. /path/to/repo/gp-app/
cd /path/to/repo/gp-app

# 5. Frontend assets
npm install && npm run build

# 6. SQLite for local development
touch database/database.sqlite
#   in .env set DB_CONNECTION=sqlite and delete the other DB_* lines

# 7. Migrate and seed
php artisan migrate
php artisan db:seed

# 8. Run it
php artisan serve
```

> `cp -rn` copies without overwriting, so the overlay files below survive. If you
> prefer, scaffold directly and copy the overlay over the top with plain `cp -r`.

---

## Seeded accounts

All 15 accounts use the password **`password`**.

| Email | Name | Role | Department |
|---|---|---|---|
| `admin@graphicspixels.test` | Ajijul Haque | Admin | Administration |
| `marketing1@graphicspixels.test` | David Joy | Marketing Manager | Marketing |
| `marketing2@graphicspixels.test` | MD. Sahab Uddin | Marketing Manager | Marketing |
| `production1@graphicspixels.test` | Omar Faruk | Production Manager | Production |
| `production2@graphicspixels.test` | Muntasir Mahmud Chowdhury | Production Manager | Production |
| `lead1@graphicspixels.test` | Al-Amin | Team Leader | Production |
| `lead2@graphicspixels.test` | Md Sojib Alam | Team Leader | Production |
| `lead3@graphicspixels.test` | Tariqul Islam | Team Leader | Production |
| `editor1@graphicspixels.test` | Mushlay Uddin Himel | Editor | Production |
| `editor2@graphicspixels.test` | Rakib Hasan | Editor | Production |
| `editor3@graphicspixels.test` | Nayeem Islam | Editor | Production |
| `editor4@graphicspixels.test` | Shakil Ahmed | Editor | Production |
| `editor5@graphicspixels.test` | Jubayer Alam | Editor | Production |
| `qc1@graphicspixels.test` | Forhad Hossain Fahim | QC Staff | Quality Control |
| `qc2@graphicspixels.test` | Md. Reyaj Hassan | QC Staff | Quality Control |

Editors 1–2 report to `lead1`, editors 3–4 to `lead2`, editor 5 to `lead3`.

> These are development credentials with a shared weak password. Do not seed them
> into a production environment.

---

## Permission matrix

25 permissions across 8 groups, defined in `app/Support/PermissionMatrix.php`.
Admin resolves to *all* permissions dynamically, so anything added in a later
phase is granted to administrators automatically.

| Role | Permissions |
|---|---|
| **Admin** | everything (25) |
| **Marketing Manager** | `leads.view` `leads.create` `leads.update` `leads.assign` `clients.view` `clients.manage` `reports.view` |
| **Production Manager** | `orders.*` `batches.view` `batches.create` `batches.assign` `qc.view` `clients.view` `staff.view` `staff.workload.view` `reports.view` `reports.export` |
| **Team Leader** | `orders.view` `batches.view` `batches.create` `batches.assign` `qc.view` `staff.workload.view` |
| **Editor** | `batches.view` `batches.update.own` |
| **QC Staff** | `batches.view` `qc.view` `qc.approve` `qc.reject` |

Phase 1 only *seeds* these names and binds them to roles — the features that
consume them come later. The sidebar is already gated on them, so the navigation
visibly differs per role.

---

## Manual test

```bash
php artisan serve
```

Log in as each account above and confirm:

1. You are redirected from `/dashboard` to your role's dashboard.
2. The navbar shows your role and department badges.
3. The sidebar lists only the sections your role can see — an Editor sees just
   **Batches**; an Admin sees all eight.
4. The right-hand panel lists your actual permissions (2 for an Editor, 25 for
   an Admin).
5. Visiting another role's dashboard directly (e.g. `/dashboard/admin` as an
   editor) returns **403**.

## Automated test

```bash
php artisan test --filter=RoleAccessTest
```

`tests/Feature/RoleAccessTest.php` covers the redirect map, cross-role 403s, the
full permission matrix per role, the seeded role distribution, and the
editor→team-leader links.

---

## Verification status

Because Composer was unavailable, the checks below were run through
`tools/verify-phase1-standalone.php` — a harness that loads the real
`PermissionMatrix` and `StaffRoster` classes and executes the schema and seed
logic against an in-memory SQLite database with plain PDO. It needs no
dependencies, so you can re-run it any time:

```bash
php tools/verify-phase1-standalone.php
```

Once Laravel is installed, `php artisan test` supersedes it.

**Verified** (executed against a live SQLite database via PDO, 40 assertions, all passing):

- Schema builds: `users` with the added staff columns, plus all five Spatie tables
- All 25 permissions and 6 roles seed correctly
- Every role's grants resolve correctly through SQL joins, including negative
  cases (Editor cannot `orders.create`, Marketing cannot `qc.approve`, …)
- Editor's grant set is exactly `[batches.update.own, batches.view]`
- Roster seeds 15 users with the 1/2/2/3/5/2 distribution
- Department matches role for all 15 users
- All 5 editors link to a real team leader; non-editors have none
- Each role maps to a distinct dashboard route

Also checked: `php -l` clean on all 13 PHP files; all Blade directives balanced
and every `@include` target resolves; every Laravel and Spatie API used was
confirmed against the actual framework source.

**Not verified** — needs a real install, please confirm locally:

- Application boot and `php artisan migrate` actually running
- HTTP login, session handling, and the middleware redirects at runtime
- Blade template rendering and Vite asset compilation

---

## Files in this overlay

```
app/Enums/Department.php              Four departments
app/Enums/RoleName.php                Six roles → department + dashboard route
app/Support/PermissionMatrix.php      Single source of truth for permissions
app/Support/StaffRoster.php           The 15 development staff accounts
app/Models/User.php                   HasRoles, department cast, team relations
app/Http/Controllers/DashboardController.php
bootstrap/app.php                     Registers Spatie middleware aliases
database/migrations/2025_01_01_000001_add_staff_fields_to_users_table.php
database/seeders/{DatabaseSeeder,RolePermissionSeeder,UserSeeder}.php
routes/web.php                        Role-gated dashboard routes + Breeze auth
resources/views/layouts/app.blade.php
resources/views/partials/{navbar,sidebar,role-panel}.blade.php
resources/views/dashboard/*.blade.php Six role dashboards + unassigned
tests/Feature/RoleAccessTest.php
```

`PermissionMatrix` and `StaffRoster` are deliberately free of framework
dependencies so they can be asserted against in isolation.

---

## Next phase

**Phase 2 — Lead intake & CRM.** The WordPress theme on the `wp-graphicspixels`
branch already posts free-trial and contact submissions to an external webhook
(`GP_APP_WEBHOOK_URL`, Bearer `GP_APP_API_KEY`, in `inc/submissions.php`), so
phase 2 builds the `POST /api/submissions` endpoint that receives them, plus the
lead pipeline and client profiles.
