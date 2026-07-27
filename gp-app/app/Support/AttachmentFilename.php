<?php

namespace App\Support;

/**
 * Derives a safe storage filename from a remote attachment URL.
 *
 * The URL originates outside the application, so the filename is treated as
 * untrusted: directory separators, traversal sequences and anything outside a
 * conservative character set are stripped before the value is ever used in a
 * storage path.
 *
 * Framework-independent so it can be asserted against directly.
 */
final class AttachmentFilename
{
    private const MAX_LENGTH = 120;

    public static function fromUrl(?string $url, string $fallback = 'attachment'): string
    {
        $path = parse_url((string) $url, PHP_URL_PATH);

        // basename() drops any directory portion; the character filter below
        // then removes anything that could reintroduce one.
        $name = urldecode(basename((string) $path));

        $name = (string) preg_replace('/[^A-Za-z0-9._-]/', '_', $name);

        // Collapse runs of dots so no ".." traversal sequence can survive.
        $name = (string) preg_replace('/\.{2,}/', '.', $name);

        $name = trim($name, '._-');

        if ($name === '') {
            return $fallback;
        }

        return self::truncate($name);
    }

    /**
     * Shorten the stem while preserving a short extension.
     */
    private static function truncate(string $name): string
    {
        if (mb_strlen($name) <= self::MAX_LENGTH) {
            return $name;
        }

        $extension = pathinfo($name, PATHINFO_EXTENSION);

        if ($extension !== '' && mb_strlen($extension) <= 10) {
            $stem = pathinfo($name, PATHINFO_FILENAME);

            return mb_substr($stem, 0, self::MAX_LENGTH - mb_strlen($extension) - 1).'.'.$extension;
        }

        return mb_substr($name, 0, self::MAX_LENGTH);
    }
}
