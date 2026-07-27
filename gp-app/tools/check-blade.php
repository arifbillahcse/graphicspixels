<?php

/**
 * Blade cannot be compiled without Laravel, so this does the two checks that
 * catch the mistakes that actually happen: unbalanced block directives, and
 * @include targets that do not resolve to a file.
 */

$viewRoot = dirname(__DIR__).'/resources/views';

$pairs = [
    'if' => 'endif',
    'foreach' => 'endforeach',
    'forelse' => 'endforelse',
    'for' => 'endfor',
    'while' => 'endwhile',
    'can' => 'endcan',
    'cannot' => 'endcannot',
    'isset' => 'endisset',
    'empty' => 'endempty',
    'auth' => 'endauth',
    'guest' => 'endguest',
    'section' => 'endsection',
    'push' => 'endpush',
];

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewRoot));
$problems = [];
$checked = 0;

foreach ($files as $file) {
    if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }

    $checked++;
    $path = $file->getPathname();
    $rel = str_replace($viewRoot.'/', '', $path);
    $src = file_get_contents($path);

    foreach ($pairs as $open => $close) {
        // Opening directive: @if( ... but not @ifsomething
        $openCount = preg_match_all('/@'.$open.'\s*\(/', $src);
        $closeCount = preg_match_all('/@'.$close.'\b/', $src);

        if ($openCount !== $closeCount) {
            $problems[] = "{$rel}: @{$open} x{$openCount} vs @{$close} x{$closeCount}";
        }
    }

    // @php blocks (the inline @php(...) form needs no @endphp)
    $phpBlocks = preg_match_all('/@php(?!\s*\()/', $src);
    $phpEnds = preg_match_all('/@endphp\b/', $src);
    if ($phpBlocks !== $phpEnds) {
        $problems[] = "{$rel}: @php block x{$phpBlocks} vs @endphp x{$phpEnds}";
    }

    // @include targets must resolve to a real view file
    if (preg_match_all("/@include\s*\(\s*'([^']+)'/", $src, $m)) {
        foreach ($m[1] as $view) {
            $target = $viewRoot.'/'.str_replace('.', '/', $view).'.blade.php';
            if (! file_exists($target)) {
                $problems[] = "{$rel}: @include('{$view}') -> missing {$target}";
            } else {
                echo "  ok  {$rel} includes {$view}\n";
            }
        }
    }
}

echo "\nChecked {$checked} blade files.\n";

if ($problems) {
    echo "\nPROBLEMS:\n";
    foreach ($problems as $p) {
        echo "  - {$p}\n";
    }
    exit(1);
}

echo "All blade directives balanced; all @include targets resolve.\n";
exit(0);
