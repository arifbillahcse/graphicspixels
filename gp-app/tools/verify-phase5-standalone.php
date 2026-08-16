<?php

/**
 * Phase 5 verification harness.
 *
 * Composer is unavailable in the environment this was written in, so Laravel
 * cannot boot. This loads the framework-independent Phase 5 classes and:
 *
 *   1. Walks DateRange's overlap rule across its boundaries — the single
 *      shared day at each end is what decides whether leave blocks a date.
 *   2. Checks the workload bands and their meter.
 *   3. Executes the leave schema against SQLite and runs the real availability
 *      query, including the case that matters: a pending request must not take
 *      somebody out of the assignment pool.
 *
 * Run: php tools/verify-phase5-standalone.php
 */

$appRoot = dirname(__DIR__);

require $appRoot.'/app/Enums/LeaveType.php';
require $appRoot.'/app/Enums/LeaveStatus.php';
require $appRoot.'/app/Support/DateRange.php';
require $appRoot.'/app/Support/WorkloadLevel.php';

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use App\Support\DateRange;
use App\Support\WorkloadLevel;

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
// 1. Date ranges.
// ---------------------------------------------------------------------------

section('Range overlap, walked across the boundary');

$leave = new DateRange('2026-07-20', '2026-07-24');

$cases = [
    ['2026-07-15', '2026-07-19', false, 'ends the day before'],
    ['2026-07-15', '2026-07-20', true, 'ends on the first day'],
    ['2026-07-21', '2026-07-22', true, 'entirely inside'],
    ['2026-07-18', '2026-07-30', true, 'entirely surrounds'],
    ['2026-07-24', '2026-07-28', true, 'starts on the last day'],
    ['2026-07-25', '2026-07-28', false, 'starts the day after'],
    ['2026-07-20', '2026-07-20', true, 'single day at the start'],
    ['2026-07-24', '2026-07-24', true, 'single day at the end'],
];

foreach ($cases as [$start, $end, $expected, $label]) {
    $other = new DateRange($start, $end);
    check("Overlap: {$label}", $leave->overlaps($other) === $expected);
    check("Overlap is symmetric: {$label}", $other->overlaps($leave) === $expected);
}

check('contains() is inclusive at the start', $leave->contains('2026-07-20'));
check('contains() is inclusive at the end', $leave->contains('2026-07-24'));
check('contains() excludes the day before', ! $leave->contains('2026-07-19'));
check('contains() excludes the day after', ! $leave->contains('2026-07-25'));

section('Range construction');

check('Reversed dates are ordered', (string) (new DateRange('2026-07-24', '2026-07-20')) === '2026-07-20..2026-07-24');
check('A reversed range still overlaps correctly',
    (new DateRange('2026-07-24', '2026-07-20'))->overlaps(DateRange::day('2026-07-22')));
check('Single day', DateRange::day('2026-07-22')->isSingleDay());
check('Inclusive day count', $leave->days() === 5, (string) $leave->days());
check('Single day counts as one', DateRange::day('2026-07-22')->days() === 1);

// endExclusive exists because a timestamp at 14:00 on the last day is inside
// the range, but "<= 2026-07-24" against a datetime column would miss it.
check('endExclusive is the day after', $leave->endExclusive() === '2026-07-25');

section('Calendar windows');

// 2026-07-22 is a Wednesday.
check('Week runs Monday to Sunday', (string) DateRange::week('2026-07-22') === '2026-07-20..2026-07-26');
check('Week from its own Monday is stable', (string) DateRange::week('2026-07-20') === '2026-07-20..2026-07-26');
check('Week from its own Sunday does not roll forward', (string) DateRange::week('2026-07-26') === '2026-07-20..2026-07-26');
check('A week is seven days', DateRange::week('2026-07-22')->days() === 7);

check('Month covers the calendar month', (string) DateRange::month('2026-07-15') === '2026-07-01..2026-07-31');
check('Short month handled', (string) DateRange::month('2026-02-10') === '2026-02-01..2026-02-28');
check('Leap February handled', (string) DateRange::month('2024-02-10') === '2024-02-01..2024-02-29');
check('Month length is right', DateRange::month('2026-02-10')->days() === 28);

check('Previous week', (string) DateRange::week('2026-07-22')->previous() === '2026-07-13..2026-07-19');
check('Previous month-length window',
    DateRange::month('2026-07-15')->previous()->days() === 31,
    (string) DateRange::month('2026-07-15')->previous());

// Year boundaries are the classic off-by-one.
check('Week spanning new year',
    (string) DateRange::week('2027-01-01') === '2026-12-28..2027-01-03',
    (string) DateRange::week('2027-01-01'));
check('December month', (string) DateRange::month('2026-12-15') === '2026-12-01..2026-12-31');

// ---------------------------------------------------------------------------
// 2. Workload bands.
// ---------------------------------------------------------------------------

section('Workload bands');

$bands = [
    [0, WorkloadLevel::IDLE], [1, WorkloadLevel::LIGHT], [2, WorkloadLevel::LIGHT],
    [3, WorkloadLevel::STEADY], [5, WorkloadLevel::STEADY],
    [6, WorkloadLevel::HEAVY], [20, WorkloadLevel::HEAVY],
];

foreach ($bands as [$n, $expected]) {
    check("{$n} open batches is {$expected}", WorkloadLevel::forOpenBatches($n) === $expected,
        WorkloadLevel::forOpenBatches($n));
}

check('Negative counts read as idle', WorkloadLevel::forOpenBatches(-1) === WorkloadLevel::IDLE);
check('Six is the overload threshold', WorkloadLevel::isOverloaded(6));
check('Five is not overloaded', ! WorkloadLevel::isOverloaded(5));
check('Meter is capped at 100%', WorkloadLevel::percent(50) === 100);
check('Meter is 0 when idle', WorkloadLevel::percent(0) === 0);
check('Every band has a label',
    count(array_unique(array_map(fn ($l) => WorkloadLevel::label($l), [
        WorkloadLevel::IDLE, WorkloadLevel::LIGHT, WorkloadLevel::STEADY, WorkloadLevel::HEAVY,
    ]))) === 4);

// Idle is deliberately not green — an editor with nothing to do is actionable.
check('Idle is not green', ! str_contains(WorkloadLevel::badgeClasses(WorkloadLevel::IDLE), 'green'));
check('Heavy is red', str_contains(WorkloadLevel::badgeClasses(WorkloadLevel::HEAVY), 'red'));

section('Leave statuses');

check('Only approved leave blocks availability',
    count(array_filter(LeaveStatus::cases(), fn (LeaveStatus $s) => $s->blocksAvailability())) === 1);
check('Approved blocks', LeaveStatus::Approved->blocksAvailability());
check('Pending does not block', ! LeaveStatus::Pending->blocksAvailability());
check('Denied does not block', ! LeaveStatus::Denied->blocksAvailability());
check('Cancelled does not block', ! LeaveStatus::Cancelled->blocksAvailability());
check('Pending is undecided', ! LeaveStatus::Pending->isDecided());
check('Approved is decided', LeaveStatus::Approved->isDecided());
check('Four leave types', count(LeaveType::cases()) === 4);

// ---------------------------------------------------------------------------
// 3. Schema and the availability query.
// ---------------------------------------------------------------------------

section('Leave schema and availability');

$db = new PDO('sqlite::memory:');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec('PRAGMA foreign_keys = ON');

$db->exec('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR, is_active TINYINT DEFAULT 1)');
$db->exec(<<<'SQL'
CREATE TABLE leave_requests (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE,
    type VARCHAR NOT NULL DEFAULT 'annual',
    starts_on DATE NOT NULL,
    ends_on DATE NOT NULL,
    reason TEXT NULL,
    status VARCHAR NOT NULL DEFAULT 'pending',
    reviewed_by INTEGER NULL REFERENCES users (id) ON DELETE SET NULL,
    reviewed_at DATETIME NULL,
    review_note TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)
SQL);

check('Schema builds', true);

$db->exec("INSERT INTO users (name) VALUES ('Away'), ('Pending'), ('Working'), ('Denied')");

$insert = $db->prepare('INSERT INTO leave_requests (user_id, starts_on, ends_on, status) VALUES (?, ?, ?, ?)');
$insert->execute([1, '2026-07-20', '2026-07-24', LeaveStatus::Approved->value]);
$insert->execute([2, '2026-07-20', '2026-07-24', LeaveStatus::Pending->value]);
$insert->execute([4, '2026-07-20', '2026-07-24', LeaveStatus::Denied->value]);

/** The availability query User::scopeAvailableOn compiles to. */
$available = $db->prepare(
    "SELECT COUNT(*) FROM users u
     WHERE u.is_active = 1
       AND NOT EXISTS (
           SELECT 1 FROM leave_requests l
           WHERE l.user_id = u.id AND l.status = 'approved'
             AND l.starts_on <= :d AND l.ends_on >= :d
       )"
);

$available->execute(['d' => '2026-07-22']);
check('Only the approved absence is excluded mid-leave', (int) $available->fetchColumn() === 3);

$available->execute(['d' => '2026-07-20']);
check('Excluded on the first day of leave', (int) $available->fetchColumn() === 3);

$available->execute(['d' => '2026-07-24']);
check('Excluded on the last day of leave', (int) $available->fetchColumn() === 3);

$available->execute(['d' => '2026-07-19']);
check('Available the day before leave starts', (int) $available->fetchColumn() === 4);

$available->execute(['d' => '2026-07-25']);
check('Available the day after leave ends', (int) $available->fetchColumn() === 4);

// The important one: an unapproved request must not silently starve somebody
// of work.
$onlyPending = $db->query(
    "SELECT COUNT(*) FROM leave_requests l
     WHERE l.user_id = 2 AND l.status = 'approved'
       AND l.starts_on <= '2026-07-22' AND l.ends_on >= '2026-07-22'"
)->fetchColumn();
check('A pending request does not remove somebody from the pool', (int) $onlyPending === 0);

section('Overlapping-request guard');

// Booking leave twice over the same days would double-count an absence.
//
// Mirrors LeaveRequest::scopeOverlapping. The comparison is deliberately
// cross-wise — an existing row overlaps when it starts on or before the new
// END and finishes on or after the new START. Named parameters here because
// binding these two the obvious way round is exactly the mistake to avoid.
$clash = $db->prepare(
    "SELECT COUNT(*) FROM leave_requests
     WHERE user_id = :user AND status IN ('pending','approved')
       AND starts_on <= :end AND ends_on >= :start"
);

$clash->execute(['user' => 1, 'start' => '2026-07-22', 'end' => '2026-07-26']);
check('An overlapping booking is detected', (int) $clash->fetchColumn() === 1);

$clash->execute(['user' => 1, 'start' => '2026-07-18', 'end' => '2026-07-21']);
check('A booking overlapping the start is detected', (int) $clash->fetchColumn() === 1);

$clash->execute(['user' => 1, 'start' => '2026-07-21', 'end' => '2026-07-22']);
check('A booking entirely inside is detected', (int) $clash->fetchColumn() === 1);

$clash->execute(['user' => 1, 'start' => '2026-07-25', 'end' => '2026-07-28']);
check('A neighbouring booking is allowed', (int) $clash->fetchColumn() === 0);

$clash->execute(['user' => 1, 'start' => '2026-07-15', 'end' => '2026-07-19']);
check('A booking finishing the day before is allowed', (int) $clash->fetchColumn() === 0);

$clash->execute(['user' => 4, 'start' => '2026-07-20', 'end' => '2026-07-24']);
check('A denied request does not block rebooking', (int) $clash->fetchColumn() === 0);

// The DateRange overlap rule and this SQL must agree, or the guard and the
// availability check would disagree about the same pair of dates.
$existing = new DateRange('2026-07-20', '2026-07-24');
$agreements = 0;
foreach ([['2026-07-22', '2026-07-26'], ['2026-07-25', '2026-07-28'], ['2026-07-18', '2026-07-21']] as [$s, $e]) {
    $clash->execute(['user' => 1, 'start' => $s, 'end' => $e]);
    $sql = (int) $clash->fetchColumn() > 0;
    $php = $existing->overlaps(new DateRange($s, $e));
    $agreements += ($sql === $php) ? 1 : 0;
}
check('DateRange::overlaps agrees with the SQL guard', $agreements === 3, "{$agreements}/3");

section('Cascades');

$db->exec('DELETE FROM users WHERE id = 1');
check('Deleting a person removes their leave',
    (int) $db->query('SELECT COUNT(*) FROM leave_requests WHERE user_id = 1')->fetchColumn() === 0);

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
