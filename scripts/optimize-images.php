<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "This script is CLI-only.\n");
    exit(1);
}

$files = array_slice($argv, 1);

if ($files === []) {
    fwrite(STDERR, "Usage: php scripts/optimize-images.php <png> [png...]\n");
    exit(1);
}

foreach ($files as $file) {
    if (!is_file($file)) {
        fwrite(STDERR, "Missing file: {$file}\n");
        exit(1);
    }

    $source = imagecreatefrompng($file);
    if ($source === false) {
        fwrite(STDERR, "Cannot read PNG: {$file}\n");
        exit(1);
    }

    $sourceWidth = imagesx($source);
    $sourceHeight = imagesy($source);
    $maxWidth = str_contains(basename($file), 'hero') ? 1600 : 960;
    $targetWidth = min($sourceWidth, $maxWidth);
    $targetHeight = (int) round($sourceHeight * ($targetWidth / $sourceWidth));
    $target = imagecreatetruecolor($targetWidth, $targetHeight);

    if ($target === false) {
        imagedestroy($source);
        fwrite(STDERR, "Cannot allocate target image: {$file}\n");
        exit(1);
    }

    imagecopyresampled(
        $target,
        $source,
        0,
        0,
        0,
        0,
        $targetWidth,
        $targetHeight,
        $sourceWidth,
        $sourceHeight
    );

    $output = preg_replace('/\.png$/i', '.webp', $file);
    if (!is_string($output) || !imagewebp($target, $output, 84)) {
        imagedestroy($source);
        imagedestroy($target);
        fwrite(STDERR, "Cannot write WebP: {$file}\n");
        exit(1);
    }

    imagedestroy($source);
    imagedestroy($target);
    fwrite(STDOUT, basename($output) . " {$targetWidth}x{$targetHeight}\n");
}
