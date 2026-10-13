<?php
declare(strict_types=1);
?>
<section class="bike-hero van-hero" aria-labelledby="van-title">
    <div class="bike-hero__media">
        <img src="<?= e(asset($page['hero_image'])) ?>" width="<?= (int) $page['hero_image_width'] ?>" height="<?= (int) $page['hero_image_height'] ?>" alt="<?= e($page['hero_alt']) ?>" fetchpriority="high" loading="eager">
    </div>
    <div class="container bike-hero__inner">
        <div class="bike-hero__content">
            <p class="eyebrow"><?= e($page['eyebrow']) ?></p>
            <h1 id="van-title"><?= e($page['title']) ?></h1>
            <p><?= e($page['description']) ?></p>
            <div class="bike-hero__actions van-hero__actions">
                <button class="button" type="button" data-open-registration>Đăng ký tư vấn</button>
                <a class="button button--secondary" href="#quyen-loi">Xem thông tin nổi bật</a>
            </div>
        </div>
    </div>
</section>

<?php if (($site['features']['countdown'] ?? false) && ($site['features']['countdown_mode'] ?? '') === 'session_preview'): ?>
<section class="countdown-strip" aria-labelledby="countdown-title">
    <div class="container countdown-strip__inner">
        <div>
            <h2 id="countdown-title">Đăng ký nhận tư vấn</h2>
            <p class="countdown-note">Đồng hồ minh họa · Không phải hạn ưu đãi</p>
        </div>
        <div class="countdown" data-countdown data-storage-key="xanhsm-van-countdown-target" data-duration="<?= e((string) $site['features']['countdown_seconds']) ?>" aria-label="Đồng hồ đếm ngược minh họa tám giờ">
            <div><strong data-hours>08</strong><span>Giờ</span></div><b aria-hidden="true">:</b>
            <div><strong data-minutes>00</strong><span>Phút</span></div><b aria-hidden="true">:</b>
            <div><strong data-seconds>00</strong><span>Giây</span></div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require BASE_PATH . '/app/views/components/inline-registration.php'; ?>

<?php
foreach (['benefits', 'documents', 'process', 'stories', 'faq'] as $section) {
    require BASE_PATH . '/app/views/components/' . $section . '.php';
}
