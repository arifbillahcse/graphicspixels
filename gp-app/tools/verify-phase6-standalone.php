<?php

/**
 * Phase 6 verification harness.
 *
 * Composer is unavailable in the environment this was written in, so Laravel
 * cannot boot. This loads the framework-independent Phase 6 classes and:
 *
 *   1. Checks the notification catalog is internally consistent.
 *   2. Exercises channel resolution, which decides whether somebody is emailed.
 *      The rules that matter: an explicit preference wins even when it is
 *      false, an unknown key sends nothing at all, and switching everything off
 *      means silence rather than a fallback to the default.
 *   3. Executes the notification schema against SQLite.
 *
 * Run: php tools/verify-phase6-standalone.php
 */

$appRoot = dirname(__DIR__);

require $appRoot.'/app/Support/NotificationCatalog.php';
require $appRoot.'/app/Support/ChannelResolver.php';

use App\Support\ChannelResolver as R;
use App\Support\NotificationCatalog as C;

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
// 1. Catalog consistency.
// ---------------------------------------------------------------------------

section('Notification catalog');

$keys = C::keys();

check('Catalog is not empty', $keys !== []);
check('Keys are unique', count($keys) === count(array_unique($keys)));

$badShape = [];
$badKeyFormat = [];

foreach ($keys as $key) {
    $type = C::get($key);

    if (! is_array($type)
        || ($type['label'] ?? '') === ''
        || ($type['description'] ?? '') === ''
        || ($type['group'] ?? '') === ''
        || ! is_bool($type['email'] ?? null)
        || ! is_bool($type['in_app'] ?? null)) {
        $badShape[] = $key;
    }

    // Keys are namespaced so it stays obvious what a notification is about.
    if (! preg_match('/^[a-z_]+\.[a-z_]+$/', $key)) {
        $badKeyFormat[] = $key;
    }
}

check('Every entry is fully described', $badShape === [], implode(', ', $badShape));
check('Every key is namespaced like area.event', $badKeyFormat === [], implode(', ', $badKeyFormat));

$labels = array_map(fn ($k) => C::label($k), $keys);
check('Labels are distinct', count($labels) === count(array_unique($labels)));

// Something reachable by no channel at all would be dead configuration.
$unreachable = array_filter($keys, function ($k) {
    $d = C::defaults($k);

    return ! $d['email'] && ! $d['in_app'];
});
check('No notification defaults to being undeliverable', $unreachable === [], implode(', ', $unreachable));

$grouped = C::grouped();
$groupedCount = array_sum(array_map('count', $grouped));
check('Grouping covers every key', $groupedCount === count($keys), "{$groupedCount} vs ".count($keys));

check('Unknown keys are reported missing', ! C::has('nope.nope'));
check('Unknown key returns null', C::get('nope.nope') === null);
check('Unknown key falls back to itself as a label', C::label('nope.nope') === 'nope.nope');

// The important default: an unknown key must not quietly default to email.
$unknownDefaults = C::defaults('nope.nope');
check('Unknown key defaults to no email', $unknownDefaults['email'] === false);
check('Unknown key defaults to no in-app', $unknownDefaults['in_app'] === false);

section('Default channel choices');

// Interruptive things should reach people by mail; routine assignment should
// not, or the studio drowns in it at 10,000 images a day.
check('Rework coming back defaults to email', C::defaults('batch.rejected')['email']);
check('An SLA warning defaults to email', C::defaults('order.at_risk')['email']);
check('An order handed to your team defaults to email', C::defaults('order.assigned')['email']);
check('A routine batch assignment does not default to email', ! C::defaults('batch.assigned')['email']);
check('A routine lead assignment does not default to email', ! C::defaults('lead.assigned')['email']);
check('Every notification defaults to in-app',
    count(array_filter($keys, fn ($k) => C::defaults($k)['in_app'])) === count($keys));

// ---------------------------------------------------------------------------
// 2. Channel resolution.
// ---------------------------------------------------------------------------

section('Channel resolution');

check('No preference uses the catalog default (in-app only)',
    R::resolve('batch.assigned') === ['database'], json_encode(R::resolve('batch.assigned')));

check('No preference uses the catalog default (both)',
    R::resolve('batch.rejected') === ['database', 'mail'], json_encode(R::resolve('batch.rejected')));

check('An unknown key resolves to nothing', R::resolve('nope.nope') === []);
check('An unknown key resolves to nothing even with a preference',
    R::resolve('nope.nope', ['email' => true, 'in_app' => true]) === []);

// An explicit "no" has to stick, or turning a notification off would do nothing.
check('Switching everything off silences a notification',
    R::resolve('batch.rejected', ['email' => false, 'in_app' => false]) === []);
check('Opting out of email only leaves in-app',
    R::resolve('batch.rejected', ['email' => false, 'in_app' => true]) === ['database']);
check('Opting into email on a default-off type works',
    R::resolve('batch.assigned', ['email' => true, 'in_app' => true]) === ['database', 'mail']);
check('Email only',
    R::resolve('batch.assigned', ['email' => true, 'in_app' => false]) === ['mail']);

// A half-written preference row must not lose the other channel.
check('A partial preference falls back per flag',
    R::resolve('batch.rejected', ['email' => false]) === ['database'],
    json_encode(R::resolve('batch.rejected', ['email' => false])));
check('An empty preference array behaves like no preference',
    R::resolve('batch.rejected', []) === R::resolve('batch.rejected'));

check('wantsEmail agrees with resolve', R::wantsEmail('batch.rejected'));
check('wantsEmail is false when opted out', ! R::wantsEmail('batch.rejected', ['email' => false]));
check('wantsInApp agrees with resolve', R::wantsInApp('batch.assigned'));
check('wantsInApp is false when opted out', ! R::wantsInApp('batch.assigned', ['in_app' => false]));

// Channel names have to be the ones Laravel actually understands.
$allChannels = [];
foreach ($keys as $key) {
    $allChannels = array_merge($allChannels, R::resolve($key, ['email' => true, 'in_app' => true]));
}
check('Only known Laravel channels are produced',
    array_diff(array_unique($allChannels), ['database', 'mail']) === [],
    implode(', ', array_unique($allChannels)));

check('In-app is always ordered before email',
    R::resolve('batch.rejected') === ['database', 'mail']);

// ---------------------------------------------------------------------------
// 3. Schema.
// ---------------------------------------------------------------------------

section('Notification schema');

$db = new PDO('sqlite::memory:');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = ON');

$db->exec('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR)');

$db->exec(<<<'SQL'
CREATE TABLE notifications (
    id VARCHAR PRIMARY KEY,
    type VARCHAR NOT NULL,
    notifiable_type VARCHAR NOT NULL,
    notifiable_id INTEGER NOT NULL,
    data TEXT NOT NULL,
    read_at DATETIME NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);
$db->exec('CREATE INDEX notifications_notifiable_read_index ON notifications (notifiable_type, notifiable_id, read_at)');

$db->exec(<<<'SQL'
CREATE TABLE notification_preferences (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE,
    notification_key VARCHAR NOT NULL,
    email TINYINT NOT NULL DEFAULT 0,
    in_app TINYINT NOT NULL DEFAULT 1,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);
$db->exec('CREATE UNIQUE INDEX notification_preferences_user_key_unique ON notification_preferences (user_id, notification_key)');

check('Schema builds', true);

$db->exec("INSERT INTO users (name) VALUES ('Editor'), ('Manager')");

$insert = $db->prepare(
    'INSERT INTO notifications (id, type, notifiable_type, notifiable_id, data, read_at, created_at)
     VALUES (?, ?, ?, ?, ?, ?, ?)'
);

$payload = json_encode(['key' => 'batch.assigned', 'title' => 'Batch 1 is yours', 'body' => '50 images', 'url' => '/batches/mine']);

$insert->execute(['n1', 'App\\Notifications\\BatchAssigned', 'App\\Models\\User', 1, $payload, null, '2026-07-27 09:00:00']);
$insert->execute(['n2', 'App\\Notifications\\BatchRejected', 'App\\Models\\User', 1, $payload, '2026-07-27 10:00:00', '2026-07-27 09:30:00']);
$insert->execute(['n3', 'App\\Notifications\\OrderAtRisk', 'App\\Models\\User', 2, $payload, null, '2026-07-27 09:45:00']);

$unreadFor = $db->prepare(
    "SELECT COUNT(*) FROM notifications
     WHERE notifiable_type = 'App\\Models\\User' AND notifiable_id = ? AND read_at IS NULL"
);

$unreadFor->execute([1]);
check('Unread count is per person', (int) $unreadFor->fetchColumn() === 1);

$unreadFor->execute([2]);
check('Another person has their own count', (int) $unreadFor->fetchColumn() === 1);

check('Stored payload round-trips',
    json_decode((string) $db->query("SELECT data FROM notifications WHERE id = 'n1'")->fetchColumn(), true)['key']
        === 'batch.assigned');

section('Preferences');

$prefs = $db->prepare('INSERT INTO notification_preferences (user_id, notification_key, email, in_app) VALUES (?, ?, ?, ?)');
$prefs->execute([1, 'batch.rejected', 0, 1]);

// One row per person per type: two would make the resolved channels ambiguous.
$dupeRejected = false;
try {
    $prefs->execute([1, 'batch.rejected', 1, 1]);
} catch (PDOException) {
    $dupeRejected = true;
}
check('One preference row per person per type', $dupeRejected);
check('The same key for another person is fine', (function () use ($prefs, $db) {
    $prefs->execute([2, 'batch.rejected', 1, 1]);

    return (int) $db->query('SELECT COUNT(*) FROM notification_preferences')->fetchColumn() === 2;
})());

// The stored row is what ChannelResolver is handed, so check the round trip.
$stored = $db->query("SELECT email, in_app FROM notification_preferences WHERE user_id = 1 AND notification_key = 'batch.rejected'")
    ->fetch(PDO::FETCH_ASSOC);

check('A stored opt-out resolves to in-app only',
    R::resolve('batch.rejected', ['email' => (bool) $stored['email'], 'in_app' => (bool) $stored['in_app']]) === ['database']);

$db->exec('DELETE FROM users WHERE id = 1');
check('Deleting a user removes their preferences',
    (int) $db->query('SELECT COUNT(*) FROM notification_preferences WHERE user_id = 1')->fetchColumn() === 0);

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
