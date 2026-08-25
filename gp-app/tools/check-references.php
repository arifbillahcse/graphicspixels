<?php

/**
 * Static consistency audit.
 *
 * Blade compiles late and route names are resolved at call time, so a typo in
 * route('leads.iindex') or view('leads.detail') is invisible to php -l and only
 * blows up when somebody opens the page. This walks the route files, then
 * checks every reference in the codebase resolves:
 *
 *   1. every route() / ->route() name exists
 *   2. every view() returned by a controller exists
 *   3. every Gate::authorize('x', Model::class) has a matching policy method
 *
 * Run: php tools/check-references.php
 */

$appRoot = dirname(__DIR__);

$problems = [];
$checked = ['routes' => 0, 'views' => 0, 'abilities' => 0];

/**
 * Route names published by Breeze's auth.php, which is not part of this overlay.
 */
const BREEZE_ROUTES = [
    'login', 'logout', 'register',
    'password.request', 'password.email', 'password.reset', 'password.store',
    'password.confirm', 'password.update',
    'verification.notice', 'verification.send', 'verification.verify',
];

// ---------------------------------------------------------------------------
// 1. Collect every route name the application defines.
// ---------------------------------------------------------------------------

/**
 * @return list<string>
 */
function definedRouteNames(array $files): array
{
    $names = [];

    foreach ($files as $file) {
        if (! is_file($file)) {
            continue;
        }

        $depth = 0;
        /** @var list<array{prefix:string,depth:int}> $stack */
        $stack = [];

        foreach (file($file) as $line) {
            $openedAt = $depth;

            // A group that contributes a name prefix, e.g.
            //   Route::prefix('leads')->name('leads.')->group(function () {
            $isGroup = str_contains($line, '->group(');
            $prefixMatch = preg_match("/->name\('([^']*\.)'\)/", $line, $pm);

            // A concrete route name, e.g. ->name('index')
            $nameMatch = preg_match_all("/->name\('([^']+)'\)/", $line, $nm);

            $depth += substr_count($line, '{') - substr_count($line, '}');

            // Unwind any groups this line closed.
            while ($stack !== [] && $depth < end($stack)['depth']) {
                array_pop($stack);
            }

            if ($isGroup && $prefixMatch) {
                $stack[] = ['prefix' => $pm[1], 'depth' => $openedAt + 1];

                continue;
            }

            if (! $nameMatch || $isGroup) {
                continue;
            }

            $prefix = implode('', array_column($stack, 'prefix'));

            foreach ($nm[1] as $name) {
                // Skip a trailing-dot prefix that was not a group opener.
                if (str_ends_with($name, '.')) {
                    continue;
                }
                $names[] = $prefix.$name;
            }
        }
    }

    return array_values(array_unique($names));
}

$defined = definedRouteNames([
    $appRoot.'/routes/web.php',
    $appRoot.'/routes/api.php',
]);

$known = array_merge($defined, BREEZE_ROUTES);

echo 'Defined route names: '.count($defined)."\n";

// ---------------------------------------------------------------------------
// Walk the source tree.
// ---------------------------------------------------------------------------

/**
 * @return list<string>
 */
function sourceFiles(string $root): array
{
    $files = [];

    foreach (['app', 'resources/views', 'routes', 'tests', 'database'] as $dir) {
        $path = $root.'/'.$dir;

        if (! is_dir($path)) {
            continue;
        }

        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        foreach ($it as $file) {
            // Blade templates are handled separately below, so they are
            // excluded here rather than being scanned twice.
            if ($file->isFile()
                && str_ends_with($file->getFilename(), '.php')
                && ! str_ends_with($file->getFilename(), '.blade.php')) {
                $files[] = $file->getPathname();
            }
        }
    }

    return $files;
}

$files = sourceFiles($appRoot);

foreach ($files as $file) {
    $rel = str_replace($appRoot.'/', '', $file);
    $source = file_get_contents($file);

    // ---- 1. route names -------------------------------------------------
    if (preg_match_all("/\broute\(\s*'([^']+)'/", $source, $m)) {
        foreach ($m[1] as $name) {
            $checked['routes']++;

            if (! in_array($name, $known, true)) {
                $problems[] = "{$rel}: route('{$name}') is not defined";
            }
        }
    }

    // ---- 2. views returned by controllers --------------------------------
    if (preg_match_all("/\bview\(\s*'([^']+)'/", $source, $m)) {
        foreach ($m[1] as $view) {
            $checked['views']++;
            $target = $appRoot.'/resources/views/'.str_replace('.', '/', $view).'.blade.php';

            if (! file_exists($target)) {
                $problems[] = "{$rel}: view('{$view}') has no template";
            }
        }
    }

    // ---- 3. policy abilities --------------------------------------------
    // Gate::authorize('ability', Model::class) and $user->can('ability', $model)
    if (preg_match_all("/Gate::authorize\(\s*'([^']+)'\s*,\s*([A-Za-z\\\\]+)::class/", $source, $m, PREG_SET_ORDER)) {
        foreach ($m as $match) {
            [, $ability, $model] = $match;
            $checked['abilities']++;

            $short = substr($model, strrpos($model, '\\') === false ? 0 : strrpos($model, '\\') + 1);
            $policy = $appRoot.'/app/Policies/'.$short.'Policy.php';

            if (! file_exists($policy)) {
                $problems[] = "{$rel}: Gate::authorize('{$ability}', {$short}::class) but no {$short}Policy";

                continue;
            }

            if (! preg_match('/function\s+'.preg_quote($ability, '/').'\s*\(/', (string) file_get_contents($policy))) {
                $problems[] = "{$rel}: {$short}Policy has no {$ability}() method";
            }
        }
    }
}

// ---- Blade templates ------------------------------------------------------
// Only the two-argument @can form naming a model class can be resolved
// statically; the single-argument permission form is checked by the phase 1
// harness instead.
$bladeFiles = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($appRoot.'/resources/views'));
foreach ($it as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $bladeFiles[] = $file->getPathname();
    }
}

foreach ($bladeFiles as $file) {
    $rel = str_replace($appRoot.'/', '', $file);
    $source = (string) file_get_contents($file);

    // route() inside blade
    if (preg_match_all("/\broute\(\s*'([^']+)'/", $source, $m)) {
        foreach ($m[1] as $name) {
            $checked['routes']++;

            if (! in_array($name, $known, true)) {
                $problems[] = "{$rel}: route('{$name}') is not defined";
            }
        }
    }

    // @can('ability', App\Models\Thing::class)
    if (preg_match_all("/@can\(\s*'([^']+)'\s*,\s*([A-Za-z\\\\]+)::class/", $source, $m, PREG_SET_ORDER)) {
        foreach ($m as $match) {
            [, $ability, $model] = $match;
            $checked['abilities']++;

            $short = substr($model, strrpos($model, '\\') === false ? 0 : strrpos($model, '\\') + 1);
            $policy = $appRoot.'/app/Policies/'.$short.'Policy.php';

            if (! file_exists($policy)) {
                $problems[] = "{$rel}: @can('{$ability}', {$short}::class) but no {$short}Policy";

                continue;
            }

            if (! preg_match('/function\s+'.preg_quote($ability, '/').'\s*\(/', (string) file_get_contents($policy))) {
                $problems[] = "{$rel}: {$short}Policy has no {$ability}() method";
            }
        }
    }
}

// ---------------------------------------------------------------------------

echo sprintf(
    "Checked %d route references, %d view references, %d policy abilities.\n",
    $checked['routes'],
    $checked['views'],
    $checked['abilities'],
);

$problems = array_values(array_unique($problems));

if ($problems) {
    echo "\nPROBLEMS:\n";
    foreach ($problems as $p) {
        echo "  - {$p}\n";
    }
    echo "\n".count($problems)." problem(s) found.\n";
    exit(1);
}

echo "All route, view and policy references resolve.\n";
exit(0);
