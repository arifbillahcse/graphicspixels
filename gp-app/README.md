# GraphicsPixels Operations Platform

Internal management application for GraphicsPixels: leads and client onboarding,
production workflow, quality control, and team management.

| Phase | Scope | State |
|---|---|---|
| **1** | Authentication, roles, permissions, staff schema, role-aware dashboards | Built |
| **2** | Lead intake webhook, CRM pipeline, activity log, attachments | Built |
| **3** | Lead conversion, orders, production board, batches, SLA | Built |
| 4 | Quality control | Not started |
| 5 | Team, HR and reporting | Not started |
| 6 | Notifications and polish | Not started |

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

### Also needed for phase 2

```bash
# Queue table + worker, so attachment downloads do not block the webhook
php artisan queue:table
php artisan migrate
#   in .env set QUEUE_CONNECTION=database
php artisan queue:work
```

Attachments are stored on the `local` disk, outside `public/`, and served only
through an authorised download route — so **no `storage:link` is required**, and
deliberately so: lead files should never be reachable by URL guessing.

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
| **Marketing Manager** | `leads.view` `leads.create` `leads.update` `leads.assign` `clients.view` `clients.manage` `reports.view` `orders.view` `orders.create` |
| **Production Manager** | `orders.*` `batches.view` `batches.create` `batches.assign` `qc.view` `clients.view` `staff.view` `staff.workload.view` `reports.view` `reports.export` |
| **Team Leader** | `orders.view` `batches.view` `batches.create` `batches.assign` `qc.view` `staff.workload.view` |
| **Editor** | `batches.view` `batches.update.own` |
| **QC Staff** | `batches.view` `qc.view` `qc.approve` `qc.reject` |

The `leads.*` and `orders.*`/`batches.*` permissions are live as of phases 2 and
3; the rest are seeded and gate the sidebar, but their features arrive later.
Editors and QC staff hold no `leads.*` or `orders.*` permission at all, so those
routes return 403 for them.

Two ownership rules sit alongside the permissions rather than inside them:

- **Team leaders** hold `orders.view` but not `orders.update`. `OrderPolicy`
  also accepts *being the order's team leader*, so they can drive their own
  queue and nobody else's, without being given blanket update rights.
- **Editors** hold `batches.update.own`, and `BatchPolicy` checks the batch is
  actually theirs. `BatchStatus::editorCanMoveTo()` further limits them to the
  legal next step, so an editor cannot move work straight to Completed and
  skip QC.

Marketing gained `orders.view` and `orders.create` in phase 3: they win the deal,
so they raise the order and can follow it. Handing it to a team leader
(`orders.assign`) and running the floor stayed with production.

---

## Connecting the WordPress site

The theme on the `wp-graphicspixels` branch already forwards submissions — see
`gp_forward_to_app()` in `inc/submissions.php`. Point it at this app by adding
two constants to the site's `wp-config.php`:

```php
define( 'GP_APP_WEBHOOK_URL', 'https://app.graphicspixels.com/api/submissions' );
define( 'GP_APP_API_KEY', 'a-long-random-secret' );
```

Then set the same secret in this app's `.env`:

```
GP_APP_API_KEY=a-long-random-secret
```

If `GP_APP_API_KEY` is unset here the endpoint returns **503** rather than
accepting unauthenticated posts.

### Payload

The theme sends slightly different fields per form. Both are handled:

| Field | Free trial | Contact | Notes |
|---|:--:|:--:|---|
| `name`, `email` | ✓ | ✓ | Required; everything else is optional |
| `phone`, `service`, `message` | ✓ | ✓ | Blank fields arrive as `""` and are stored as `NULL` |
| `website` | ✓ | — | |
| `company` | — | ✓ | |
| `file_link` | ✓ | — | Cloud link the client pasted instead of uploading |
| `attachment_url` | ✓ | ✓ | URL in the WP media library, not the file itself |
| `form` | ✓ | ✓ | `Free Trial Request` / `Contact Message` → lead source |
| `submitted_at` | ✓ | ✓ | ISO-8601, site timezone |
| `wp_entry_id` | ✓ | ✓ | WP post ID — the idempotency key |

**Duplicates.** `wp_entry_id` is unique, so a re-delivered submission returns
`200 {"duplicate": true}` and logs a note on the existing lead instead of
creating a second one. Submissions without a `wp_entry_id` are not deduplicated.

**Attachments.** WordPress sends a URL, not file content, so the download happens
in a queued job (`FetchLeadAttachment`) — the theme's webhook call times out
after 8 seconds. Without a queue worker the job runs inline and may exceed that.

### Try it

```bash
curl -X POST http://localhost:8000/api/submissions \
  -H "Authorization: Bearer a-long-random-secret" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Buyer",
    "email": "jane@example.com",
    "phone": "+44 7700 900123",
    "website": "https://example.com",
    "service": "Clipping Path",
    "message": "Please quote for 500 images.",
    "form": "Free Trial Request",
    "submitted_at": "2026-07-27T10:15:00+06:00",
    "wp_entry_id": 4021
  }'
```

Expect `201` with a `lead_id`. Repeat the same command and you get `200` with
`"duplicate": true`, and still only one lead.

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

Then, as `marketing1@graphicspixels.test`:

6. Post the sample submission above and confirm the lead appears under **Leads**.
7. Move it between stages on the board and open it — the transition is in the
   activity log.
8. Add a note, and assign it to another marketing user; both appear in the log.
9. Select several leads in table view and apply a bulk status change.
10. As `editor1@graphicspixels.test`, visit `/leads` — **403**, and Leads is
    absent from the sidebar.

## Automated test

```bash
php artisan test
```

| Suite | Covers |
|---|---|
| `RoleAccessTest` | Redirect map, cross-role 403s, permission matrix per role, seeded roster, editor→team-leader links |
| `SubmissionWebhookTest` | Token auth, both real WP payload shapes, empty-string handling, duplicate suppression, validation, attachment queueing, scheme filtering |
| `LeadPipelineTest` | Who may see and act on leads, status/assign/note logging, bulk actions, attachment download authorisation and cross-lead access |
| `OrderWorkflowTest` | Lead→client→order conversion, returning-client reuse, board access, status moves (form and JSON), team-leader ownership, batch splitting and auto-assign, editor isolation, SLA bands and the at-risk scope |

---

## Verification status

Composer was unavailable in the environment this was written in, so Laravel could
not boot. Verification instead runs through standalone harnesses that load the
real framework-independent classes and execute them against an in-memory SQLite
database with plain PDO. They need no dependencies, so you can re-run them any
time:

```bash
php tools/verify-phase1-standalone.php   # 42 assertions
php tools/verify-phase2-standalone.php   # 55 assertions
php tools/verify-phase3-standalone.php   # 99 assertions
php tools/check-blade.php                # directive balance + @include targets
```

Once Laravel is installed, `php artisan test` supersedes them.

**Verified — phase 1** (40 assertions, all passing):

- Schema builds: `users` with the added staff columns, plus all five Spatie tables
- All 25 permissions and 6 roles seed correctly
- Every role's grants resolve correctly through SQL joins, including negative
  cases (Editor cannot `orders.create`, Marketing cannot `qc.approve`, …)
- Editor's grant set is exactly `[batches.update.own, batches.view]`
- Roster seeds 15 users with the 1/2/2/3/5/2 distribution, correct departments,
  and every editor linked to a real team leader

**Verified — phase 2** (55 assertions, all passing):

- `SubmissionPayload` normalises both real WP bodies: email lowercased, blank
  strings to `NULL`, form label to lead source, unknown labels to `other`,
  numeric-string and zero `wp_entry_id` handled, oversized fields truncated
- Attachment URLs: `https` accepted, `file://` and `javascript:` rejected, the
  single and array shapes merged and de-duplicated
- `AttachmentFilename` survives traversal attempts — `../../etc/passwd`,
  percent-encoded traversal and `....//` all yield a name with no separator or
  `..`, and long names keep their extension
- The unique index on `wp_entry_id` genuinely rejects a second insert, while
  `NULL` entry IDs stay insertable — this is what makes retries safe
- Deleting a lead cascades to its activities and attachments
- Status transitions persist `{from, to}` in the activity properties

**Verified — phase 3** (99 assertions, all passing):

- `BatchPlanner` conserves every image across both split modes, spreads the
  remainder so sizes never differ by more than one, clamps a request for more
  batches than images, and never emits an empty batch
- Assignment skips a loaded editor until the others catch up, levels uneven
  loads out, and leaves the caller's load array unmutated
- The SLA bands were walked across their exact boundaries — 12h, 11h59m, 4h,
  3h59m, on the deadline, one minute over — plus the 80% at-risk rule, the
  delivered met/missed outcomes, and a zero-length window that would otherwise
  divide by zero
- Duplicate order references and duplicate batch numbers within an order are
  both rejected, while batch numbers restart correctly per order
- The at-risk query returns nothing 12h in, both orders past 80%, and drops
  delivered orders
- Deleting a batch removes its notes but leaves order-level notes; deleting an
  order cascades to both; removing an editor leaves their batches in place
- `ServiceType::guessFrom()` matches website free text including American
  spelling, and returns null rather than guessing wrong

Also checked: `php -l` clean on all 64 PHP files; all 26 Blade templates have
balanced directives and resolving `@include` targets; every Laravel and Spatie
API used was confirmed against the actual framework source.

**Not verified** — needs a real install, please confirm locally:

- Application boot and `php artisan migrate` actually running
- HTTP login, session handling, middleware redirects and policy 403s at runtime
- Blade rendering and Vite asset compilation
- The queued attachment download against a real WordPress media URL

---

## Files in this overlay

**Phase 1 — foundation**

```
app/Enums/{Department,RoleName}.php     Departments; roles → department + route
app/Support/PermissionMatrix.php        Single source of truth for permissions
app/Support/StaffRoster.php             The 15 development staff accounts
app/Models/User.php                     HasRoles, department cast, team relations
app/Http/Controllers/DashboardController.php
bootstrap/app.php                       Middleware aliases + api route file
database/migrations/2025_01_01_000001_add_staff_fields_to_users_table.php
database/seeders/{DatabaseSeeder,RolePermissionSeeder,UserSeeder}.php
resources/views/layouts/app.blade.php
resources/views/partials/{navbar,sidebar,role-panel,flash}.blade.php
resources/views/dashboard/*.blade.php   Six role dashboards + unassigned
tests/Feature/RoleAccessTest.php
```

**Phase 2 — lead pipeline**

```
app/Enums/{LeadStatus,LeadSource,ActivityAction}.php
app/Support/SubmissionPayload.php       Normalises the WP webhook body
app/Support/AttachmentFilename.php      Hardened filename derivation
app/Models/{Lead,LeadActivity,LeadAttachment}.php
app/Http/Middleware/VerifyWebhookToken.php
app/Http/Requests/StoreSubmissionRequest.php
app/Http/Controllers/Api/SubmissionController.php
app/Http/Controllers/{LeadController,LeadAttachmentController}.php
app/Policies/LeadPolicy.php             Maps abilities onto leads.* permissions
app/Jobs/FetchLeadAttachment.php        Copies WP media into local storage
config/graphicspixels.php               Webhook key + attachment limits
database/migrations/2025_02_01_00000{1,2,3}_*.php
database/factories/LeadFactory.php
routes/api.php                          POST /api/submissions
resources/views/leads/                  Board, table, detail, create, edit
resources/views/partials/lead-summary.blade.php
tests/Feature/{SubmissionWebhookTest,LeadPipelineTest}.php
tools/                                  Standalone verification harnesses
```

**Phase 3 — production**

```
app/Enums/{OrderStatus,BatchStatus,ServiceType,RateTier}.php
app/Support/Sla.php                     Countdown, risk bands, at-risk rule
app/Support/BatchPlanner.php            Splitting + load-balanced assignment
app/Support/OrderReference.php          GP-YYYY-NNNN references
app/Models/{Client,Order,Batch,OrderNote}.php
app/Policies/{OrderPolicy,BatchPolicy}.php
app/Http/Controllers/LeadConversionController.php
app/Http/Controllers/{OrderController,BatchController}.php
database/migrations/2025_03_01_00000{1,2,3,4}_*.php
database/factories/{ClientFactory,OrderFactory,BatchFactory}.php
resources/views/orders/                 Board, card, detail, conversion form
resources/views/batches/mine.blade.php  Editor work queue
resources/views/partials/production-summary.blade.php
tests/Feature/OrderWorkflowTest.php
```

`PermissionMatrix`, `StaffRoster`, `SubmissionPayload` and `AttachmentFilename`
are deliberately free of framework dependencies so they can be asserted against
in isolation — that is what makes the standalone harnesses possible.

---

## Next phase

**Phase 4 — Quality control.** A QC queue of batches marked Ready for QC,
service-specific checklists, approve/reject with blocker and minor comments, the
rework loop back to the original editor, and per-editor defect rates.
