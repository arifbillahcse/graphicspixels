<?php

/**
 * Phase 4 verification harness.
 *
 * Composer is unavailable in the environment this was written in, so Laravel
 * cannot boot. This loads the framework-independent Phase 4 classes and:
 *
 *   1. Checks every service has a usable QC checklist.
 *   2. Exercises DefectRate, including the small-sample guard that stops one
 *      rejection out of two reading as a 50% defect rate.
 *   3. Executes the Phase 4 schema against SQLite, and walks a batch through
 *      the full reject-rework-approve loop.
 *
 * Run: php tools/verify-phase4-standalone.php
 */

$appRoot = dirname(__DIR__);

require $appRoot.'/app/Enums/OrderStatus.php';
require $appRoot.'/app/Enums/BatchStatus.php';
require $appRoot.'/app/Enums/ServiceType.php';
require $appRoot.'/app/Enums/QcOutcome.php';
require $appRoot.'/app/Enums/QcSeverity.php';
require $appRoot.'/app/Support/QcChecklist.php';
require $appRoot.'/app/Support/DefectRate.php';

use App\Enums\BatchStatus;
use App\Enums\QcOutcome;
use App\Enums\QcSeverity;
use App\Enums\ServiceType;
use App\Support\DefectRate;
use App\Support\QcChecklist;

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
// 1. Checklists.
// ---------------------------------------------------------------------------

section('QC checklists');

$missing = [];
$tooShort = [];
$duplicated = [];

foreach (ServiceType::cases() as $service) {
    $items = QcChecklist::for($service);

    if ($items === []) {
        $missing[] = $service->value;
    }

    if (count($items) < 3) {
        $tooShort[] = $service->value;
    }

    if (count($items) !== count(array_unique($items))) {
        $duplicated[] = $service->value;
    }
}

check('Every service has a checklist', $missing === [], implode(', ', $missing));
check('Every checklist has at least three checks', $tooShort === [], implode(', ', $tooShort));
check('No checklist repeats an item', $duplicated === [], implode(', ', $duplicated));

// The brief named these three explicitly.
check('Clipping path covers edges, halos and transparency',
    count(array_filter(QcChecklist::for(ServiceType::ClippingPath), fn ($i) => str_contains(strtolower($i), 'edge')
        || str_contains(strtolower($i), 'halo')
        || str_contains(strtolower($i), 'transparen'))) >= 3);

check('Retouching covers skin, colour and artefacts',
    count(array_filter(QcChecklist::for(ServiceType::PhotoRetouching), fn ($i) => str_contains(strtolower($i), 'skin')
        || str_contains(strtolower($i), 'colour')
        || str_contains(strtolower($i), 'artefact'))) >= 3);

check('Ghost mannequin covers seams, proportions and alignment',
    count(array_filter(QcChecklist::for(ServiceType::GhostMannequin), fn ($i) => str_contains(strtolower($i), 'seam')
        || str_contains(strtolower($i), 'joint')
        || str_contains(strtolower($i), 'proportion')
        || str_contains(strtolower($i), 'symmetr'))) >= 2);

check('Every service has its own list rather than the fallback',
    count(array_filter(ServiceType::cases(), fn (ServiceType $s) => QcChecklist::hasSpecificList($s)))
        === count(ServiceType::cases()));

check('A general fallback exists for future services', count(QcChecklist::general()) >= 3);

// ---------------------------------------------------------------------------
// 2. Defect rates.
// ---------------------------------------------------------------------------

section('Defect rate calculation');

check('No reviews is 0%', DefectRate::calculate(0, 0) === 0.0);
check('Nothing rejected is 0%', DefectRate::calculate(10, 0) === 0.0);
check('Everything rejected is 100%', DefectRate::calculate(10, 10) === 100.0);
check('One of four is 25%', DefectRate::calculate(4, 1) === 25.0);
check('One of three rounds to 33.3%', DefectRate::calculate(3, 1) === 33.3);
check('Two of twenty is 10%', DefectRate::calculate(20, 2) === 10.0);

// Bad inputs must not produce a nonsense rate on a management dashboard.
check('More rejections than reviews is clamped', DefectRate::calculate(5, 99) === 100.0);
check('Negative rejections are clamped', DefectRate::calculate(5, -3) === 0.0);
check('Negative totals are safe', DefectRate::calculate(-5, 1) === 0.0);

section('High-rate flagging');

check('10% over a full sample is high', DefectRate::isHigh(10.0, 20));
check('9.9% is not high', ! DefectRate::isHigh(9.9, 20));
check('50% over two reviews is not flagged', ! DefectRate::isHigh(50.0, 2));
check('Exactly the minimum sample counts', DefectRate::isHigh(20.0, DefectRate::MIN_SAMPLE));
check('One review is not significant', ! DefectRate::isSignificant(1));
check('Five reviews are significant', DefectRate::isSignificant(5));

check('Small samples are greyed out',
    DefectRate::badgeClasses(50.0, 2) === 'bg-gray-100 text-gray-600');
check('A high rate is red', str_contains(DefectRate::badgeClasses(15.0, 20), 'red'));
check('A middling rate is amber', str_contains(DefectRate::badgeClasses(6.0, 20), 'amber'));
check('A low rate is green', str_contains(DefectRate::badgeClasses(1.0, 20), 'green'));

check('Period formats as YYYY-MM',
    DefectRate::period(new DateTimeImmutable('2026-07-27')) === '2026-07');

// ---------------------------------------------------------------------------
// 3. Schema and the review loop.
// ---------------------------------------------------------------------------

section('Phase 4 schema');

$db = new PDO('sqlite::memory:');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = ON');

$db->exec('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR)');
$db->exec('CREATE TABLE orders (id INTEGER PRIMARY KEY AUTOINCREMENT, status VARCHAR)');
$db->exec(<<<'SQL'
CREATE TABLE batches (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL REFERENCES orders (id) ON DELETE CASCADE,
    editor_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    status VARCHAR NOT NULL DEFAULT 'pending'
)
SQL);

$db->exec(<<<'SQL'
CREATE TABLE qc_reviews (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    batch_id INTEGER NOT NULL REFERENCES batches (id) ON DELETE CASCADE,
    editor_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    reviewer_id INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    outcome VARCHAR NOT NULL DEFAULT 'pending',
    checklist TEXT NULL,
    completed_at DATETIME NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);

$db->exec(<<<'SQL'
CREATE TABLE qc_comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    qc_review_id INTEGER NOT NULL REFERENCES qc_reviews (id) ON DELETE CASCADE,
    comment TEXT NOT NULL,
    severity VARCHAR NOT NULL DEFAULT 'minor',
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);

$db->exec(<<<'SQL'
CREATE TABLE defect_stats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    editor_id INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE,
    period VARCHAR NOT NULL,
    total_reviews INTEGER NOT NULL DEFAULT 0,
    rejected_count INTEGER NOT NULL DEFAULT 0,
    reject_rate NUMERIC NOT NULL DEFAULT 0,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);
$db->exec('CREATE UNIQUE INDEX defect_stats_editor_period_unique ON defect_stats (editor_id, period)');

check('Schema builds', true);

$db->exec("INSERT INTO users (name) VALUES ('Editor A'), ('QC Staff')");
$db->exec("INSERT INTO orders (status) VALUES ('qc_review')");
$db->exec("INSERT INTO batches (order_id, editor_id, status) VALUES (1, 1, 'ready_for_qc')");

// One editor may only have one row per month, or the rate double-counts.
$db->exec("INSERT INTO defect_stats (editor_id, period, total_reviews) VALUES (1, '2026-07', 1)");
$dupeRejected = false;
try {
    $db->exec("INSERT INTO defect_stats (editor_id, period, total_reviews) VALUES (1, '2026-07', 1)");
} catch (PDOException) {
    $dupeRejected = true;
}
check('One defect row per editor per month is enforced', $dupeRejected);
check('The same editor in another month is fine', (function () use ($db) {
    $db->exec("INSERT INTO defect_stats (editor_id, period, total_reviews) VALUES (1, '2026-08', 1)");

    return (int) $db->query('SELECT COUNT(*) FROM defect_stats')->fetchColumn() === 2;
})());

section('Reject, rework, approve');

$openReview = $db->prepare('INSERT INTO qc_reviews (batch_id, editor_id, outcome) VALUES (?, ?, ?)');
$complete = $db->prepare('UPDATE qc_reviews SET outcome = ?, reviewer_id = ?, completed_at = ? WHERE id = ?');
$addComment = $db->prepare('INSERT INTO qc_comments (qc_review_id, comment, severity) VALUES (?, ?, ?)');

// Round one: rejected with a blocker.
$openReview->execute([1, 1, QcOutcome::Pending->value]);
$firstReview = (int) $db->lastInsertId();

$complete->execute([QcOutcome::Rejected->value, 2, '2026-07-27 10:00:00', $firstReview]);
$addComment->execute([$firstReview, 'Halos on the left edge.', QcSeverity::Blocker->value]);
$addComment->execute([$firstReview, 'Path slightly loose.', QcSeverity::Minor->value]);

$db->exec("UPDATE batches SET status = '".BatchStatus::Revision->value."' WHERE id = 1");

check('Batch went back for revision',
    $db->query('SELECT status FROM batches WHERE id = 1')->fetchColumn() === BatchStatus::Revision->value);
check('Two findings recorded',
    (int) $db->query("SELECT COUNT(*) FROM qc_comments WHERE qc_review_id = {$firstReview}")->fetchColumn() === 2);
check('One of them is a blocker',
    (int) $db->query("SELECT COUNT(*) FROM qc_comments WHERE qc_review_id = {$firstReview} AND severity = 'blocker'")->fetchColumn() === 1);

// The editor reworks and resubmits.
$db->exec("UPDATE batches SET status = '".BatchStatus::ReadyForQc->value."' WHERE id = 1");

// Round two: approved.
$openReview->execute([1, 1, QcOutcome::Pending->value]);
$secondReview = (int) $db->lastInsertId();
$complete->execute([QcOutcome::Approved->value, 2, '2026-07-27 14:00:00', $secondReview]);
$db->exec("UPDATE batches SET status = '".BatchStatus::Completed->value."' WHERE id = 1");

check('Batch completed on the second pass',
    $db->query('SELECT status FROM batches WHERE id = 1')->fetchColumn() === BatchStatus::Completed->value);
check('Both reviews are on record',
    (int) $db->query('SELECT COUNT(*) FROM qc_reviews WHERE batch_id = 1 AND completed_at IS NOT NULL')->fetchColumn() === 2);
check('The approval did not erase the rejection',
    (int) $db->query("SELECT COUNT(*) FROM qc_reviews WHERE batch_id = 1 AND outcome = 'rejected'")->fetchColumn() === 1);

// The rate the dashboard would show for this editor: 1 rejected of 2.
$totals = $db->query(
    "SELECT COUNT(*) AS total, SUM(CASE WHEN outcome = 'rejected' THEN 1 ELSE 0 END) AS rejected
     FROM qc_reviews WHERE editor_id = 1 AND completed_at IS NOT NULL"
)->fetch(PDO::FETCH_ASSOC);

$rate = DefectRate::calculate((int) $totals['total'], (int) $totals['rejected']);
check('Rebuilt rate is 50% over two reviews', $rate === 50.0, (string) $rate);
check('But it is not flagged, being under the minimum sample',
    ! DefectRate::isHigh($rate, (int) $totals['total']));

section('Cascades');

$db->exec("DELETE FROM qc_reviews WHERE id = {$firstReview}");
check('Deleting a review removes its findings',
    (int) $db->query("SELECT COUNT(*) FROM qc_comments WHERE qc_review_id = {$firstReview}")->fetchColumn() === 0);

$db->exec('DELETE FROM batches WHERE id = 1');
check('Deleting a batch removes its reviews',
    (int) $db->query('SELECT COUNT(*) FROM qc_reviews WHERE batch_id = 1')->fetchColumn() === 0);
check('Defect history survives the batch being deleted',
    (int) $db->query('SELECT COUNT(*) FROM defect_stats')->fetchColumn() === 2);

section('QC enums');

check('Three review outcomes', count(QcOutcome::cases()) === 3);
check('Pending is not complete', ! QcOutcome::Pending->isComplete());
check('Approved is complete', QcOutcome::Approved->isComplete());
check('Rejected is complete', QcOutcome::Rejected->isComplete());
check('Two severities', count(QcSeverity::cases()) === 2);
check('Blocker renders red', str_contains(QcSeverity::Blocker->badgeClasses(), 'red'));
check('Minor renders amber', str_contains(QcSeverity::Minor->badgeClasses(), 'amber'));

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
