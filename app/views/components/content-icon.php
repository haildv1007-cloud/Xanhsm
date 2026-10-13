<?php

declare(strict_types=1);

function content_icon(string $name): string
{
    $icons = [
        'car' => '<path d="M5 11h14l2 3v4H3v-4l2-3Zm2 0 1.5-5h7l1.5 5M6 18v3m12-3v3M6 15h2m8 0h2"/>',
        'calendar' => '<path d="M7 3v4M17 3v4M4 9h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Zm3 8h3v3H8v-3Z"/>',
        'support' => '<path d="M12 21s8-4 8-11a5 5 0 0 0-9-3 5 5 0 0 0-9 3c0 7 10 11 10 11Zm0-11v6m-3-3h6"/>',
        'chart' => '<path d="M5 20v-6h3v6H5Zm6 0V9h3v11h-3Zm6 0V4h3v16h-3Z"/>',
        'document' => '<path d="M6 3h9l4 4v14H6V3Zm9 0v5h4M9 12h7M9 16h7"/>',
    ];

    return '<svg viewBox="0 0 24 24" aria-hidden="true">' . ($icons[$name] ?? $icons['document']) . '</svg>';
}
