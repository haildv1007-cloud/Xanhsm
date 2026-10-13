<?php

declare(strict_types=1);

function mobile_nav_icon(string $name): string
{
    $icons = [
        'bike' => '<circle cx="5.5" cy="17" r="2.5"/><circle cx="18.5" cy="17" r="2.5"/><path d="M8 17h6.5l2-4.5h-5l-2-4H7.5M13 8.5h3l1.5 2.5M8.5 12.5h4M6.5 9h3"/>',
        'taxi' => '<path d="M5 11h14l2 3v4H3v-4l2-3Zm2 0 1.5-4h7L17 11M8 7h8M6.5 18v2m11-2v2M6.5 15h.01M17.5 15h.01"/>',
        'register' => '<path d="M12 5v14M5 12h14"/>',
        'rto' => '<path d="M7 3h8l4 4v14H7V3Zm8 0v5h4M10 12h6m-6 4h6"/>',
        'van' => '<path d="M3 7h11v10H3V7Zm11 4h4l3 3v3h-7v-6ZM7 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm10 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>',
    ];

    return '<svg viewBox="0 0 24 24" aria-hidden="true">' . $icons[$name] . '</svg>';
}
?>
<nav class="bottom-nav" aria-label="Điều hướng nhanh trên mobile">
    <a href="/" <?= $currentRoute === '/' ? 'aria-current="page"' : '' ?>><span class="bottom-nav__icon"><?= mobile_nav_icon('bike') ?></span><span>Bike</span></a>
    <a href="/taxi" <?= $currentRoute === '/taxi' ? 'aria-current="page"' : '' ?>><span class="bottom-nav__icon"><?= mobile_nav_icon('taxi') ?></span><span>Taxi</span></a>
    <button type="button" data-open-registration><span class="bottom-nav__icon bottom-nav__icon--register"><?= mobile_nav_icon('register') ?></span><span>Đăng ký</span></button>
    <a href="/rto" <?= $currentRoute === '/rto' ? 'aria-current="page"' : '' ?>><span class="bottom-nav__icon"><?= mobile_nav_icon('rto') ?></span><span>RTO</span></a>
    <a href="/van" <?= $currentRoute === '/van' ? 'aria-current="page"' : '' ?>><span class="bottom-nav__icon"><?= mobile_nav_icon('van') ?></span><span>Van</span></a>
</nav>
