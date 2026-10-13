<?php
declare(strict_types=1);
?>
<section class="bike-hero rto-hero" aria-labelledby="rto-title">
    <div class="bike-hero__media">
        <img src="<?= e(asset($page['hero_image'])) ?>" width="1680" height="945" alt="<?= e($page['hero_alt']) ?>" fetchpriority="high" loading="eager">
    </div>
    <div class="container bike-hero__inner">
        <div class="bike-hero__content">
            <p class="eyebrow"><?= e($page['eyebrow']) ?></p>
            <h1 id="rto-title"><?= e($page['title']) ?></h1>
            <p><?= e($page['description']) ?></p>
            <div class="bike-hero__actions rto-hero__actions">
                <button class="button" type="button" data-open-registration>Đăng ký nhận tư vấn</button>
                <a class="button button--secondary" href="#tim-hieu-rto">Tìm hiểu RTO</a>
            </div>
        </div>
    </div>
</section>

<?php if (($site['features']['countdown'] ?? false) && ($site['features']['countdown_mode'] ?? '') === 'session_preview'): ?>
<section class="countdown-strip" aria-labelledby="countdown-title">
    <div class="container countdown-strip__inner">
        <h2 id="countdown-title">Đăng Ký Ngay<br><strong>Nhận Xe Điện Trong Ngày</strong></h2>
        <div class="countdown" data-countdown data-storage-key="xanhsm-rto-countdown-target" data-duration="<?= e((string) $site['features']['countdown_seconds']) ?>" aria-label="Đồng hồ đếm ngược minh họa tám giờ">
            <div><strong data-hours>08</strong><span>Giờ</span></div><b aria-hidden="true">:</b>
            <div><strong data-minutes>00</strong><span>Phút</span></div><b aria-hidden="true">:</b>
            <div><strong data-seconds>00</strong><span>Giây</span></div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require BASE_PATH . '/app/views/components/inline-registration.php'; ?>

<section class="rto-intro section" id="tim-hieu-rto" aria-labelledby="rto-intro-title">
    <div class="container rto-intro__grid">
        <div class="section-heading">
            <p class="eyebrow">Hiểu đúng về RTO</p>
            <h2 id="rto-intro-title"><?= e($page['intro']['title']) ?></h2>
            <p><?= e($page['intro']['description']) ?></p>
        </div>
        <div class="rto-intro__details">
            <article><h3>Phù hợp với ai?</h3><p><?= e($page['intro']['audience']) ?></p></article>
            <article><h3>Điểm khác biệt</h3><p><?= e($page['intro']['difference']) ?></p></article>
        </div>
    </div>
</section>

<?php require BASE_PATH . '/app/views/components/benefits.php'; ?>

<?php
foreach (['documents', 'process', 'stories', 'faq'] as $section) {
    require BASE_PATH . '/app/views/components/' . $section . '.php';
}
