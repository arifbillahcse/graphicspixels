<?php

/**
 * Phase 2 verification harness.
 *
 * Companion to verify-phase1-standalone.php. Composer is unavailable in the
 * environment this was written in, so Laravel cannot boot. This loads the
 * framework-independent Phase 2 classes directly and:
 *
 *   1. Runs the real SubmissionPayload normaliser over the exact JSON bodies
 *      the WordPress theme sends from gp_forward_to_app().
 *   2. Attacks AttachmentFilename with traversal and injection attempts.
 *   3. Executes the Phase 2 schema against SQLite and proves the idempotency
 *      constraint and cascade deletes actually hold.
 *
 * Run: php tools/verify-phase2-standalone.php
 */

$appRoot = dirname(__DIR__);

require $appRoot.'/app/Enums/Department.php';
require $appRoot.'/app/Enums/RoleName.php';
require $appRoot.'/app/Enums/LeadStatus.php';
require $appRoot.'/app/Enums/LeadSource.php';
require $appRoot.'/app/Enums/ActivityAction.php';
require $appRoot.'/app/Support/SubmissionPayload.php';
require $appRoot.'/app/Support/AttachmentFilename.php';

use App\Enums\ActivityAction;
use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Support\AttachmentFilename;
use App\Support\SubmissionPayload;

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
// 1. Payload normalisation, using the theme's real bodies.
// ---------------------------------------------------------------------------

section('Free-trial payload (as sent by the theme)');

$trial = SubmissionPayload::fromArray([
    'name' => '  Jane Buyer ',
    'email' => 'Jane@Example.COM',
    'phone' => '+44 7700 900123',
    'website' => 'https://example.com',
    'service' => 'Clipping Path',
    'message' => 'Please quote for 500 images.',
    'file_link' => 'https://drive.google.com/folder/abc',
    'form' => 'Free Trial Request',
    'submitted_at' => '2026-07-27T10:15:00+06:00',
    'wp_entry_id' => 4021,
]);

check('Name is trimmed', $trial->name === 'Jane Buyer', "got: [{$trial->name}]");
check('Email is lowercased', $trial->email === 'jane@example.com', "got: {$trial->email}");
check('Source resolves to free_trial', $trial->source === LeadSource::FreeTrial, $trial->source->value);
check('Website captured', $trial->website === 'https://example.com');
check('Cloud file link captured', $trial->fileLink === 'https://drive.google.com/folder/abc');
check('wp_entry_id parsed as int', $trial->wpEntryId === 4021);
check('Company is null on a trial payload', $trial->company === null);

section('Contact payload (as sent by the theme)');

$contact = SubmissionPayload::fromArray([
    'name' => 'Mark Retailer',
    'email' => 'mark@shop.test',
    'phone' => '',            // the theme forwards blank fields as empty strings
    'company' => 'Shop Ltd',
    'service' => '   ',
    'message' => 'Do you handle jewellery?',
    'form' => 'Contact Message',
    'submitted_at' => '2026-07-27T11:00:00+06:00',
    'wp_entry_id' => '4022',  // may arrive as a numeric string
]);

check('Source resolves to contact', $contact->source === LeadSource::Contact, $contact->source->value);
check('Company captured', $contact->company === 'Shop Ltd');
check('Empty string becomes null', $contact->phone === null);
check('Whitespace-only string becomes null', $contact->service === null);
check('Numeric string wp_entry_id parsed', $contact->wpEntryId === 4022);
check('Website is null on a contact payload', $contact->website === null);

section('Payload edge cases');

$unknown = SubmissionPayload::fromArray([
    'name' => 'X', 'email' => 'x@y.test', 'form' => 'Newsletter Signup',
]);
check('Unknown form label falls back to other', $unknown->source === LeadSource::Other, $unknown->source->value);

$noForm = SubmissionPayload::fromArray(['name' => 'X', 'email' => 'x@y.test']);
check('Missing form label falls back to other', $noForm->source === LeadSource::Other);

$explicit = SubmissionPayload::fromArray([
    'name' => 'X', 'email' => 'x@y.test', 'source' => 'manual', 'form' => 'Contact Message',
]);
check('Explicit source overrides the form label', $explicit->source === LeadSource::Manual);

$badSource = SubmissionPayload::fromArray([
    'name' => 'X', 'email' => 'x@y.test', 'source' => 'nonsense', 'form' => 'Contact Message',
]);
check('Unrecognised explicit source falls back to the form label', $badSource->source === LeadSource::Contact);

$zeroEntry = SubmissionPayload::fromArray(['name' => 'X', 'email' => 'x@y.test', 'wp_entry_id' => 0]);
check('wp_entry_id of 0 is treated as absent', $zeroEntry->wpEntryId === null);

$longName = SubmissionPayload::fromArray([
    'name' => str_repeat('a', 500), 'email' => 'x@y.test',
]);
check('Oversized field is truncated to fit the column', mb_strlen($longName->name) === 255, 'len='.mb_strlen($longName->name));

$arrayInjection = SubmissionPayload::fromArray([
    'name' => ['not', 'a', 'string'], 'email' => 'x@y.test',
]);
check('Array supplied where a string is expected becomes empty', $arrayInjection->name === '');

section('Attachment URL handling');

$withFile = SubmissionPayload::fromArray([
    'name' => 'X', 'email' => 'x@y.test',
    'attachment_url' => 'https://site.test/wp-content/uploads/2026/07/sample.jpg',
]);
check('HTTPS attachment accepted', $withFile->attachmentUrls === ['https://site.test/wp-content/uploads/2026/07/sample.jpg']);
check('hasAttachments() reflects that', $withFile->hasAttachments());

$badScheme = SubmissionPayload::fromArray([
    'name' => 'X', 'email' => 'x@y.test', 'attachment_url' => 'file:///etc/passwd',
]);
check('file:// attachment rejected', $badScheme->attachmentUrls === [], implode(',', $badScheme->attachmentUrls));

$jsScheme = SubmissionPayload::fromArray([
    'name' => 'X', 'email' => 'x@y.test', 'attachment_url' => 'javascript:alert(1)',
]);
check('javascript: attachment rejected', $jsScheme->attachmentUrls === []);

$multi = SubmissionPayload::fromArray([
    'name' => 'X', 'email' => 'x@y.test',
    'attachment_url' => 'https://a.test/1.jpg',
    'attachments' => ['https://a.test/2.jpg', ['url' => 'https://a.test/3.jpg'], 'https://a.test/1.jpg'],
]);
check('Multiple attachment shapes merged and de-duplicated', $multi->attachmentUrls === [
    'https://a.test/1.jpg', 'https://a.test/2.jpg', 'https://a.test/3.jpg',
], implode(', ', $multi->attachmentUrls));

// ---------------------------------------------------------------------------
// 2. Filename sanitisation. The URL is attacker-influenced, so this matters.
// ---------------------------------------------------------------------------

section('Attachment filename sanitisation');

$cases = [
    ['https://site.test/uploads/sample.jpg', 'sample.jpg', 'plain filename preserved'],
    ['https://site.test/uploads/my%20photo.png', 'my_photo.png', 'encoded space neutralised'],
    ['https://site.test/a/b/c/deep.pdf', 'deep.pdf', 'directory portion dropped'],
    ['https://site.test/sample.jpg?v=2&x=1', 'sample.jpg', 'query string excluded'],
];

foreach ($cases as [$url, $expected, $label]) {
    $actual = AttachmentFilename::fromUrl($url);
    check("Filename: {$label}", $actual === $expected, "got: {$actual}");
}

// Traversal attempts must never yield a name containing a separator or "..".
$attacks = [
    'https://site.test/../../../../etc/passwd',
    'https://site.test/%2e%2e%2f%2e%2e%2fetc%2fpasswd',
    'https://site.test/....//....//secret.txt',
    'https://site.test/',
    'https://site.test/...',
];

foreach ($attacks as $url) {
    $name = AttachmentFilename::fromUrl($url);

    $safe = ! str_contains($name, '/')
        && ! str_contains($name, '\\')
        && ! str_contains($name, '..')
        && $name !== ''
        && preg_match('/^[A-Za-z0-9._-]+$/', $name) === 1;

    check("Filename is safe for: {$url}", (bool) $safe, "got: [{$name}]");
}

$long = AttachmentFilename::fromUrl('https://site.test/'.str_repeat('n', 400).'.jpg');
check('Very long filename truncated', mb_strlen($long) <= 120, 'len='.mb_strlen($long));
check('Very long filename keeps its extension', str_ends_with($long, '.jpg'), "got: {$long}");

// ---------------------------------------------------------------------------
// 3. Schema, idempotency constraint and cascade deletes.
// ---------------------------------------------------------------------------

section('Phase 2 schema');

$db = new PDO('sqlite::memory:');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = ON');

$db->exec('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR, email VARCHAR)');

$db->exec(<<<'SQL'
CREATE TABLE leads (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    phone VARCHAR NULL,
    website VARCHAR NULL,
    company VARCHAR NULL,
    service VARCHAR NULL,
    message TEXT NULL,
    file_link TEXT NULL,
    status VARCHAR NOT NULL DEFAULT 'new',
    source VARCHAR NOT NULL DEFAULT 'other',
    assigned_to INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    wp_entry_id INTEGER NULL,
    submitted_at DATETIME NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);
$db->exec('CREATE UNIQUE INDEX leads_wp_entry_id_unique ON leads (wp_entry_id)');
$db->exec('CREATE INDEX leads_status_created_at_index ON leads (status, created_at)');

$db->exec(<<<'SQL'
CREATE TABLE lead_activities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lead_id INTEGER NOT NULL REFERENCES leads (id) ON DELETE CASCADE,
    user_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    action VARCHAR NOT NULL,
    note TEXT NULL,
    properties TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);

$db->exec(<<<'SQL'
CREATE TABLE lead_attachments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lead_id INTEGER NOT NULL REFERENCES leads (id) ON DELETE CASCADE,
    source_url TEXT NULL,
    disk VARCHAR NOT NULL DEFAULT 'local',
    path VARCHAR NULL,
    filename VARCHAR NULL,
    mime_type VARCHAR NULL,
    size INTEGER NULL,
    status VARCHAR NOT NULL DEFAULT 'pending',
    error TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);

check('Schema builds', true);

// Insert the normalised trial payload the way the controller would.
$insert = $db->prepare(
    'INSERT INTO leads (name, email, phone, website, company, service, message, file_link, source, wp_entry_id, created_at, updated_at)
     VALUES (:name, :email, :phone, :website, :company, :service, :message, :file_link, :source, :wp_entry_id, datetime("now"), datetime("now"))'
);

$attrs = $trial->toLeadAttributes();
unset($attrs['status']);
$insert->execute($attrs);
$leadId = (int) $db->lastInsertId();

check('Lead inserted from normalised payload', $leadId > 0);

$stored = $db->query("SELECT * FROM leads WHERE id = {$leadId}")->fetch(PDO::FETCH_ASSOC);
check('Status defaults to new', $stored['status'] === LeadStatus::New->value, $stored['status']);
check('Source persisted as free_trial', $stored['source'] === 'free_trial', $stored['source']);
check('Email persisted lowercased', $stored['email'] === 'jane@example.com');

section('Idempotency');

// The same wp_entry_id must not be storable twice: this is what stops a
// re-delivered webhook creating a duplicate lead.
$duplicateRejected = false;
try {
    $insert->execute($attrs);
} catch (PDOException) {
    $duplicateRejected = true;
}
check('Re-inserting the same wp_entry_id is rejected by the unique index', $duplicateRejected);
check('Still only one lead', (int) $db->query('SELECT COUNT(*) FROM leads')->fetchColumn() === 1);

// Leads without a wp_entry_id must remain insertable more than once, because
// SQL NULL is never equal to NULL.
$noEntry = $db->prepare('INSERT INTO leads (name, email, source) VALUES (?, ?, ?)');
$noEntry->execute(['A', 'a@test.test', 'contact']);
$noEntry->execute(['B', 'b@test.test', 'contact']);
check('Leads with a null wp_entry_id are not blocked by the unique index',
    (int) $db->query('SELECT COUNT(*) FROM leads')->fetchColumn() === 3);

section('Activity log and cascade deletes');

$db->prepare('INSERT INTO lead_activities (lead_id, user_id, action, properties) VALUES (?, NULL, ?, ?)')
    ->execute([$leadId, ActivityAction::Created->value, null]);

$db->prepare('INSERT INTO lead_activities (lead_id, user_id, action, properties) VALUES (?, NULL, ?, ?)')
    ->execute([$leadId, ActivityAction::StatusChanged->value, json_encode(['from' => 'new', 'to' => 'contacted'])]);

$db->prepare('INSERT INTO lead_attachments (lead_id, source_url, status) VALUES (?, ?, ?)')
    ->execute([$leadId, 'https://site.test/sample.jpg', 'pending']);

check('Activities recorded', (int) $db->query("SELECT COUNT(*) FROM lead_activities WHERE lead_id = {$leadId}")->fetchColumn() === 2);
check('Attachment recorded as pending',
    $db->query("SELECT status FROM lead_attachments WHERE lead_id = {$leadId}")->fetchColumn() === 'pending');

$props = json_decode(
    (string) $db->query("SELECT properties FROM lead_activities WHERE action = 'status_changed'")->fetchColumn(),
    true,
);
check('Status transition stores from/to', ($props['from'] ?? null) === 'new' && ($props['to'] ?? null) === 'contacted');

$db->exec("DELETE FROM leads WHERE id = {$leadId}");
check('Deleting a lead cascades to its activities',
    (int) $db->query("SELECT COUNT(*) FROM lead_activities WHERE lead_id = {$leadId}")->fetchColumn() === 0);
check('Deleting a lead cascades to its attachments',
    (int) $db->query("SELECT COUNT(*) FROM lead_attachments WHERE lead_id = {$leadId}")->fetchColumn() === 0);

section('Pipeline enum');

check('Six pipeline stages', count(LeadStatus::cases()) === 6);
check('Converted is a closed stage', LeadStatus::Converted->isClosed());
check('Lost is a closed stage', LeadStatus::Lost->isClosed());
check('New is not a closed stage', ! LeadStatus::New->isClosed());
check('Every stage has a distinct label',
    count(array_unique(array_map(fn (LeadStatus $s) => $s->label(), LeadStatus::cases()))) === 6);
check('Every stage has badge classes',
    count(array_filter(array_map(fn (LeadStatus $s) => $s->badgeClasses(), LeadStatus::cases()))) === 6);

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
