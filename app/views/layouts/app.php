<?php

declare(strict_types=1);

$pageTitle = $page['seo']['title'] ?? $site['name'];
$pageDescription = $page['seo']['description'] ?? '';
$isLanding = in_array($page['slug'] ?? '', ['bike', 'taxi', 'rto', 'van'], true);
$siteUrl = rtrim((string) ($site['url'] ?? ''), '/');
$pageRoute = (string) ($page['seo']['canonical_route'] ?? $page['route'] ?? $currentRoute ?? '/');
$canonicalUrl = $siteUrl !== '' && $isLanding ? $siteUrl . ($pageRoute === '/' ? '/' : $pageRoute) : '';
$heroImage = (string) ($page['hero_image'] ?? '');
$heroAsset = $heroImage !== '' ? asset($heroImage) : '';
$openGraphImage = $siteUrl !== '' && $heroAsset !== '' ? $siteUrl . $heroAsset : '';
$gtmId = preg_match('/^GTM-[A-Z0-9]+$/', (string) ($site['gtm_id'] ?? '')) ? (string) $site['gtm_id'] : '';
require_once BASE_PATH . '/app/views/components/content-icon.php';
?>
<!doctype html>
<html lang="<?= e($site['language']) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="<?= e($site['theme_color']) ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= e(asset('assets/images/logo.png')) ?>">
    <link rel="apple-touch-icon" href="<?= e(asset('assets/images/logo.png')) ?>">
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="robots" content="<?= e((string) ($page['seo']['robots'] ?? ($isLanding ? 'index,follow' : 'noindex,follow'))) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <?php if ($canonicalUrl !== ''): ?>
        <link rel="canonical" href="<?= e($canonicalUrl) ?>">
        <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <?php endif; ?>
    <?php if ($openGraphImage !== ''): ?>
        <meta property="og:image" content="<?= e($openGraphImage) ?>">
        <meta name="twitter:image" content="<?= e($openGraphImage) ?>">
    <?php endif; ?>
    <title><?= e($pageTitle) ?></title>
    <?php if ($heroAsset !== ''): ?>
        <link rel="preload" as="image" href="<?= e($heroAsset) ?>" fetchpriority="high">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= e(asset('assets/css/app.css')) ?>">
    <?php if ($gtmId !== ''): ?>
        <script>window.dataLayer=window.dataLayer||[];window.dataLayer.push({'gtm.start':Date.now(),event:'gtm.js'});</script>
        <script async src="https://www.googletagmanager.com/gtm.js?id=<?= e(rawurlencode($gtmId)) ?>"></script>
    <?php endif; ?>
    <script defer src="<?= e(asset('assets/js/app.js')) ?>"></script>
</head>
<body class="page page--<?= e($page['slug'] ?? 'error') ?>">
    <?php if ($gtmId !== ''): ?>
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= e(rawurlencode($gtmId)) ?>" height="0" width="0" class="gtm-noscript" title="Google Tag Manager"></iframe></noscript>
    <?php endif; ?>
    <a class="skip-link" href="#noi-dung">Bỏ qua điều hướng</a>
    <?php require BASE_PATH . '/app/views/components/header.php'; ?>

    <main id="noi-dung">
        <?php require $contentView; ?>
    </main>

    <?php require BASE_PATH . '/app/views/components/footer.php'; ?>
    <?php require BASE_PATH . '/app/views/components/legal-modal.php'; ?>

    <?php if ($isLanding): ?>
        <?php require BASE_PATH . '/app/views/components/registration-modal.php'; ?>
        <?php require BASE_PATH . '/app/views/components/success-modal.php'; ?>
        <?php require BASE_PATH . '/app/views/components/story-modal.php'; ?>
        <?php require BASE_PATH . '/app/views/components/support-bubble.php'; ?>
        <?php require BASE_PATH . '/app/views/components/mobile-nav.php'; ?>
    <?php endif; ?>
</body>
</html>
