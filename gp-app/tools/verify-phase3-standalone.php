<?php

/**
 * Phase 3 verification harness.
 *
 * Composer is unavailable in the environment this was written in, so Laravel
 * cannot boot. This loads the framework-independent Phase 3 classes and:
 *
 *   1. Exercises BatchPlanner's splitting and load-balanced assignment,
 *      including the edge cases that silently corrupt an order (more batches
 *      than images, uneven remainders, no editors).
 *   2. Walks the SLA bands across their exact boundaries.
 *   3. Executes the Phase 3 schema against SQLite and proves the constraints
 *      and cascade deletes actually hold.
 *
 * Run: php tools/verify-phase3-standalone.php
 */

$appRoot = dirname(__DIR__);

require $appRoot.'/app/Enums/OrderStatus.php';
require $appRoot.'/app/Enums/BatchStatus.php';
require $appRoot.'/app/Enums/ServiceType.php';
require $appRoot.'/app/Enums/RateTier.php';
require $appRoot.'/app/Support/BatchPlanner.php';
require $appRoot.'/app/Support/Sla.php';
require $appRoot.'/app/Support/OrderReference.php';

use App\Enums\BatchStatus;
use App\Enums\OrderStatus;
use App\Enums\ServiceType;
use App\Support\BatchPlanner;
use App\Support\OrderReference;
use App\Support\Sla;

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
// 1. Batch splitting.
// ---------------------------------------------------------------------------

section('Splitting by batch count');

$cases = [
    [10, 3, [4, 3, 3], 'remainder spread over the earliest batches'],
    [9, 3, [3, 3, 3], 'even split'],
    [1, 1, [1], 'single image'],
    [100, 4, [25, 25, 25, 25], 'large even split'],
    [7, 2, [4, 3], 'odd total'],
];

foreach ($cases as [$images, $count, $expected, $label]) {
    $actual = BatchPlanner::byCount($images, $count);
    check("byCount({$images}, {$count}): {$label}", $actual === $expected, json_encode($actual));
    check("byCount({$images}, {$count}) conserves every image", array_sum($actual) === $images);
}

// More batches than images would create empty batches for editors to pick up.
$clamped = BatchPlanner::byCount(2, 5);
check('byCount clamps batches to the image count', $clamped === [1, 1], json_encode($clamped));
check('byCount never produces an empty batch', ! in_array(0, $clamped, true));

check('byCount(0, 3) produces nothing', BatchPlanner::byCount(0, 3) === []);
check('byCount(10, 0) produces nothing', BatchPlanner::byCount(10, 0) === []);
check('byCount rejects negatives', BatchPlanner::byCount(-5, 3) === []);

section('Splitting by batch size');

$sizeCases = [
    [10, 3, [3, 3, 3, 1], 'trailing part-batch'],
    [9, 3, [3, 3, 3], 'exact fit'],
    [10, 20, [10], 'size larger than the order'],
    [5, 1, [1, 1, 1, 1, 1], 'one image per batch'],
];

foreach ($sizeCases as [$images, $size, $expected, $label]) {
    $actual = BatchPlanner::bySize($images, $size);
    check("bySize({$images}, {$size}): {$label}", $actual === $expected, json_encode($actual));
    check("bySize({$images}, {$size}) conserves every image", array_sum($actual) === $images);
}

check('bySize(10, 0) produces nothing', BatchPlanner::bySize(10, 0) === []);

// A realistic upper end: the studio advertises up to 10,000 images a day.
$big = BatchPlanner::bySize(10000, 250);
check('bySize handles a 10,000 image order', count($big) === 40 && array_sum($big) === 10000, count($big).' batches');

section('Load-balanced assignment');

$even = BatchPlanner::assign(4, [1 => 0, 2 => 0, 3 => 0]);
check('Level editors get plain round-robin', $even === [1, 2, 3, 1], json_encode($even));

// The whole point: a busy editor should be skipped until the others catch up.
$uneven = BatchPlanner::assign(3, [5 => 0, 7 => 2, 9 => 0]);
check('A loaded editor is skipped', $uneven === [5, 9, 5], json_encode($uneven));
check('The loaded editor got nothing', ! in_array(7, $uneven, true));

$catchUp = BatchPlanner::assign(6, [1 => 3, 2 => 0]);
check('Assignment levels the load out',
    array_count_values($catchUp)[2] > array_count_values($catchUp)[1],
    json_encode($catchUp));

check('No editors means no assignments', BatchPlanner::assign(3, []) === []);
check('No batches means no assignments', BatchPlanner::assign(0, [1 => 0]) === []);

$loads = [1 => 0, 2 => 0];
BatchPlanner::assign(4, $loads);
check('The caller\'s load array is not mutated', $loads === [1 => 0, 2 => 0], json_encode($loads));

$plan = BatchPlanner::plan([5, 5], [1 => 0, 2 => 0]);
check('plan() pairs sizes with owners',
    $plan === [['images' => 5, 'editor_id' => 1], ['images' => 5, 'editor_id' => 2]],
    json_encode($plan));

$unassignedPlan = BatchPlanner::plan([5, 5], []);
check('plan() leaves batches unowned when there are no editors',
    $unassignedPlan[0]['editor_id'] === null && $unassignedPlan[1]['editor_id'] === null);

// ---------------------------------------------------------------------------
// 2. SLA bands, walked across their boundaries.
// ---------------------------------------------------------------------------

section('SLA bands (green over 12h, amber 4-12h, red under 4h)');

$start = new DateTimeImmutable('2026-07-27 00:00:00');
$deadline = $start->modify('+24 hours');

/** Build an SLA whose "now" leaves $minutes on the clock. */
$at = fn (int $minutes) => new Sla($start, $deadline, null, $deadline->modify("-{$minutes} minutes"));

$bands = [
    [1440, Sla::RISK_OK, 'full window remaining'],
    [721, Sla::RISK_OK, 'just over 12h'],
    [720, Sla::RISK_OK, 'exactly 12h'],
    [719, Sla::RISK_WARNING, 'just under 12h'],
    [300, Sla::RISK_WARNING, '5h'],
    [240, Sla::RISK_WARNING, 'exactly 4h'],
    [239, Sla::RISK_CRITICAL, 'just under 4h'],
    [30, Sla::RISK_CRITICAL, '30 minutes'],
    [0, Sla::RISK_CRITICAL, 'on the deadline'],
    [-1, Sla::RISK_BREACHED, 'one minute over'],
    [-600, Sla::RISK_BREACHED, '10h over'],
];

foreach ($bands as [$minutes, $expected, $label]) {
    $sla = $at($minutes);
    check("{$label} -> {$expected}", $sla->risk() === $expected, 'got '.$sla->risk());
}

section('SLA at-risk rule (80% of the window consumed)');

check('4.8h remaining is exactly 80% elapsed and at risk', $at(288)->isAtRisk());
check('5h remaining is under 80% and not at risk', ! $at(300)->isAtRisk());
check('Breached is at risk', $at(-60)->isAtRisk());
check('Fresh order is not at risk', ! $at(1440)->isAtRisk());

check('percentElapsed at half way', abs($at(720)->percentElapsed() - 50.0) < 0.2, (string) $at(720)->percentElapsed());
check('percentElapsed past the deadline exceeds 100', $at(-60)->percentElapsed() > 100);

section('SLA for delivered orders');

$onTime = new Sla($start, $deadline, $deadline->modify('-2 hours'));
check('Delivered before the deadline is met', $onTime->risk() === Sla::RISK_MET);
check('A met order is not at risk', ! $onTime->isAtRisk());

$late = new Sla($start, $deadline, $deadline->modify('+3 hours'));
check('Delivered after the deadline is missed', $late->risk() === Sla::RISK_MISSED);
check('A missed order is not flagged as at risk', ! $late->isAtRisk());
check('A delivered order stops counting down',
    $onTime->minutesRemaining() === 120, (string) $onTime->minutesRemaining());

section('SLA labels');

check('Hours and minutes', $at(372)->label() === '6h 12m left', $at(372)->label());
check('Minutes only', $at(45)->label() === '45m left', $at(45)->label());
check('Overdue reads as over', $at(-90)->label() === '1h 30m over', $at(-90)->label());

// A zero-length window must not divide by zero.
$degenerate = new Sla($start, $start, null, $start);
check('Zero-length window does not divide by zero', $degenerate->percentElapsed() === 100.0);

section('Order references');

check('Formats with padding', OrderReference::format(42, 2026) === 'GP-2026-0042');
check('Pads the first order', OrderReference::format(1, 2026) === 'GP-2026-0001');
check('Grows past four digits', OrderReference::format(12345, 2026) === 'GP-2026-12345');
check('Round-trips the sequence', OrderReference::sequenceOf('GP-2026-0042') === 42);
check('Round-trips the year', OrderReference::yearOf('GP-2026-0042') === 2026);
check('Rejects nonsense', OrderReference::sequenceOf('not-a-reference') === null);

// ---------------------------------------------------------------------------
// 3. Schema, constraints and cascades.
// ---------------------------------------------------------------------------

section('Phase 3 schema');

$db = new PDO('sqlite::memory:');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = ON');

$db->exec('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR)');
$db->exec('CREATE TABLE leads (id INTEGER PRIMARY KEY AUTOINCREMENT, email VARCHAR)');

$db->exec(<<<'SQL'
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    phone VARCHAR NULL,
    company VARCHAR NULL,
    website VARCHAR NULL,
    rate_tier VARCHAR NOT NULL DEFAULT 'standard',
    lead_id INTEGER NULL REFERENCES leads (id) ON DELETE SET NULL,
    account_manager_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    notes TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);
$db->exec('CREATE UNIQUE INDEX clients_email_unique ON clients (email)');

$db->exec(<<<'SQL'
CREATE TABLE orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    reference VARCHAR NOT NULL,
    client_id INTEGER NOT NULL REFERENCES clients (id) ON DELETE CASCADE,
    lead_id INTEGER NULL REFERENCES leads (id) ON DELETE SET NULL,
    service_type VARCHAR NOT NULL,
    image_count INTEGER NOT NULL,
    file_intake_link TEXT NULL,
    delivery_link TEXT NULL,
    status VARCHAR NOT NULL DEFAULT 'received',
    rush TINYINT NOT NULL DEFAULT 0,
    received_at DATETIME NOT NULL,
    deadline DATETIME NOT NULL,
    completed_at DATETIME NULL,
    risk_at DATETIME NULL,
    team_leader_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    created_by INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    notes TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);
$db->exec('CREATE UNIQUE INDEX orders_reference_unique ON orders (reference)');
$db->exec('CREATE INDEX orders_risk_at_index ON orders (risk_at)');

$db->exec(<<<'SQL'
CREATE TABLE batches (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL REFERENCES orders (id) ON DELETE CASCADE,
    batch_number INTEGER NOT NULL,
    image_count INTEGER NOT NULL,
    editor_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    status VARCHAR NOT NULL DEFAULT 'pending',
    started_at DATETIME NULL,
    completed_at DATETIME NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);
$db->exec('CREATE UNIQUE INDEX batches_order_id_batch_number_unique ON batches (order_id, batch_number)');

$db->exec(<<<'SQL'
CREATE TABLE order_notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL REFERENCES orders (id) ON DELETE CASCADE,
    batch_id INTEGER NULL REFERENCES batches (id) ON DELETE CASCADE,
    user_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    note TEXT NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);

check('Schema builds', true);

$db->exec("INSERT INTO users (name) VALUES ('Team Leader'), ('Editor A'), ('Editor B')");
$db->exec("INSERT INTO clients (name, email) VALUES ('Shop Ltd', 'shop@test.test')");

$insertOrder = $db->prepare(
    'INSERT INTO orders (reference, client_id, service_type, image_count, status, received_at, deadline, risk_at, team_leader_id)
     VALUES (?, 1, ?, ?, ?, ?, ?, ?, 1)'
);

$received = '2026-07-27 00:00:00';
$due = '2026-07-28 00:00:00';
$riskAt = '2026-07-27 19:12:00'; // 80% of a 24-hour window

$insertOrder->execute([
    OrderReference::format(1, 2026),
    ServiceType::ClippingPath->value,
    100,
    OrderStatus::Assigned->value,
    $received,
    $due,
    $riskAt,
]);
$orderId = (int) $db->lastInsertId();

check('Order inserted', $orderId > 0);

// The reference is quoted to clients, so a collision must be impossible.
$duplicateRejected = false;
try {
    $insertOrder->execute([
        OrderReference::format(1, 2026),
        ServiceType::PhotoRetouching->value, 50, 'received', $received, $due, $riskAt,
    ]);
} catch (PDOException) {
    $duplicateRejected = true;
}
check('Duplicate order reference is rejected', $duplicateRejected);

section('Batches');

$sizes = BatchPlanner::byCount(100, 3);
$owners = BatchPlanner::assign(count($sizes), [2 => 0, 3 => 0]);

$insertBatch = $db->prepare(
    'INSERT INTO batches (order_id, batch_number, image_count, editor_id, status) VALUES (?, ?, ?, ?, ?)'
);

foreach ($sizes as $i => $images) {
    $insertBatch->execute([$orderId, $i + 1, $images, $owners[$i], BatchStatus::Pending->value]);
}

$batchTotal = (int) $db->query("SELECT SUM(image_count) FROM batches WHERE order_id = {$orderId}")->fetchColumn();
check('Batched images match the order total', $batchTotal === 100, (string) $batchTotal);
check('Three batches created', (int) $db->query("SELECT COUNT(*) FROM batches WHERE order_id = {$orderId}")->fetchColumn() === 3);
check('Work spread across both editors',
    (int) $db->query("SELECT COUNT(DISTINCT editor_id) FROM batches WHERE order_id = {$orderId}")->fetchColumn() === 2);

// Two batches numbered the same within one order would make "Batch 2"
// ambiguous for the editors working it.
$dupeBatch = false;
try {
    $insertBatch->execute([$orderId, 1, 10, 2, 'pending']);
} catch (PDOException) {
    $dupeBatch = true;
}
check('Duplicate batch number within an order is rejected', $dupeBatch);

// The same batch number in a different order is fine.
$insertOrder->execute([OrderReference::format(2, 2026), ServiceType::DropShadow->value, 20, 'received', $received, $due, $riskAt]);
$secondOrderId = (int) $db->lastInsertId();
$insertBatch->execute([$secondOrderId, 1, 20, 2, 'pending']);
check('Batch numbers restart per order', (int) $db->query('SELECT COUNT(*) FROM batches')->fetchColumn() === 4);

section('At-risk query');

$atRisk = $db->prepare(
    "SELECT COUNT(*) FROM orders WHERE status != 'delivered' AND risk_at IS NOT NULL AND risk_at <= ?"
);

$atRisk->execute(['2026-07-27 12:00:00']);
check('Not at risk 12 hours in', (int) $atRisk->fetchColumn() === 0);

$atRisk->execute(['2026-07-27 20:00:00']);
check('At risk once past 80% of the window', (int) $atRisk->fetchColumn() === 2);

$db->exec("UPDATE orders SET status = 'delivered' WHERE id = {$orderId}");
$atRisk->execute(['2026-07-27 20:00:00']);
check('Delivered orders drop out of the at-risk list', (int) $atRisk->fetchColumn() === 1);

section('Cascade deletes');

$db->prepare('INSERT INTO order_notes (order_id, batch_id, user_id, note) VALUES (?, ?, ?, ?)')
    ->execute([$orderId, null, 1, 'Order created.']);

$batchId = (int) $db->query("SELECT id FROM batches WHERE order_id = {$orderId} LIMIT 1")->fetchColumn();
$db->prepare('INSERT INTO order_notes (order_id, batch_id, user_id, note) VALUES (?, ?, ?, ?)')
    ->execute([$orderId, $batchId, 2, 'Batch 1 in progress.']);

check('Notes recorded', (int) $db->query("SELECT COUNT(*) FROM order_notes WHERE order_id = {$orderId}")->fetchColumn() === 2);

$db->exec("DELETE FROM batches WHERE id = {$batchId}");
check('Deleting a batch cascades to its notes',
    (int) $db->query("SELECT COUNT(*) FROM order_notes WHERE batch_id = {$batchId}")->fetchColumn() === 0);
check('Order-level notes survive a batch deletion',
    (int) $db->query("SELECT COUNT(*) FROM order_notes WHERE order_id = {$orderId}")->fetchColumn() === 1);

$db->exec("DELETE FROM orders WHERE id = {$orderId}");
check('Deleting an order cascades to its batches',
    (int) $db->query("SELECT COUNT(*) FROM batches WHERE order_id = {$orderId}")->fetchColumn() === 0);
check('Deleting an order cascades to its notes',
    (int) $db->query("SELECT COUNT(*) FROM order_notes WHERE order_id = {$orderId}")->fetchColumn() === 0);

// An editor leaving must not take the studio's production history with them.
$db->exec('DELETE FROM users WHERE id = 2');
check('Removing an editor leaves their batches in place, unassigned',
    (int) $db->query('SELECT COUNT(*) FROM batches WHERE editor_id IS NULL')->fetchColumn() >= 1);

section('Pipeline enums');

check('Six order stages', count(OrderStatus::cases()) === 6);
check('Delivered is the only complete stage',
    count(array_filter(OrderStatus::cases(), fn (OrderStatus $s) => $s->isComplete())) === 1);
check('Received does not require a team leader', ! OrderStatus::Received->requiresTeamLeader());
check('Editing requires a team leader', OrderStatus::Editing->requiresTeamLeader());
check('Five batch stages', count(BatchStatus::cases()) === 5);
check('Pending, In Progress and Revision count as open',
    count(array_filter(BatchStatus::cases(), fn (BatchStatus $s) => $s->isOpen())) === 3);
check('An editor may not move a pending batch straight to completed',
    ! in_array(BatchStatus::Completed, BatchStatus::Pending->editorCanMoveTo(), true));
check('An editor moves in-progress work to QC',
    BatchStatus::InProgress->editorCanMoveTo() === [BatchStatus::ReadyForQc]);
check('An editor has nothing to do on a completed batch',
    BatchStatus::Completed->editorCanMoveTo() === []);

section('Service matching from website enquiries');

check('Matches "Clipping Path"', ServiceType::guessFrom('Clipping Path') === ServiceType::ClippingPath);
check('Matches lowercase free text', ServiceType::guessFrom('need clipping done') === ServiceType::ClippingPath);
check('Matches American spelling', ServiceType::guessFrom('color correction') === ServiceType::ColorCorrection);
check('Matches "ghost mannequin"', ServiceType::guessFrom('Ghost Mannequin & Neck Joint') === ServiceType::GhostMannequin);
check('Unknown text yields no guess', ServiceType::guessFrom('something else entirely') === null);
check('Empty text yields no guess', ServiceType::guessFrom('') === null);
check('Null yields no guess', ServiceType::guessFrom(null) === null);

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
