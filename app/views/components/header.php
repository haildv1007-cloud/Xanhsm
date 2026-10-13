<?php

declare(strict_types=1);
?>
<header class="site-header">
    <div class="container site-header__inner">
        <a class="brand" href="/" aria-label="Trang chủ đăng ký tài xế Xanh SM">
            <img class="brand__mark" src="<?= e(asset('assets/images/logo.png')) ?>" width="512" height="512" alt="" aria-hidden="true">
            <span class="brand__text">XANH SM</span>
        </a>

        <nav class="primary-nav" aria-label="Điều hướng chính">
            <?php foreach ($navigation as $item): ?>
                <a
                    href="<?= e($item['route']) ?>"
                    <?= $currentRoute === $item['route'] ? 'aria-current="page"' : '' ?>
                ><?= e($item['nav_label']) ?></a>
            <?php endforeach; ?>
        </nav>

        <?php if ($isLanding): ?>
            <button class="button button--small header-register" type="button" data-open-registration>Đăng ký</button>
        <?php else: ?>
            <a class="button button--small header-register" href="/#dang-ky">Đăng ký</a>
        <?php endif; ?>

        <button
            class="menu-toggle"
            type="button"
            aria-expanded="false"
            aria-controls="mobile-drawer"
            aria-label="Mở menu"
            data-menu-toggle
        >
            <span></span><span></span><span></span>
        </button>
    </div>

    <nav class="mobile-drawer" id="mobile-drawer" aria-label="Menu mobile" hidden>
        <div class="container mobile-drawer__inner">
            <?php foreach ($navigation as $item): ?>
                <a href="<?= e($item['route']) ?>" <?= $currentRoute === $item['route'] ? 'aria-current="page"' : '' ?>>
                    <?= e($item['nav_label']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
</header>
