<?php
declare(strict_types=1);

$participationOptions = $page['participation_options'];
$participationOrder = ['rto' => 0, 'company' => 1, 'platform' => 2];
usort(
    $participationOptions,
    static fn (array $left, array $right): int => ($participationOrder[$left['key']] ?? 99) <=> ($participationOrder[$right['key']] ?? 99)
);
?>
<section class="bike-hero">
    <div class="bike-hero__media">
        <img src="<?= e(asset($page['hero_image'])) ?>" width="<?= e((string) $page['hero_image_width']) ?>" height="<?= e((string) $page['hero_image_height']) ?>" alt="Hai tài xế Xanh SM Bike bên xe máy điện trong khu đô thị" fetchpriority="high" loading="eager">
    </div>
    <div class="container bike-hero__inner">
        <div class="bike-hero__content">
            <p class="eyebrow"><?= e($page['eyebrow']) ?></p>
            <h1>Bắt đầu hành trình<br>cùng Xanh SM Bike</h1>
            <p><?= e($page['description']) ?></p>
            <div class="bike-hero__actions">
                <button class="button" type="button" data-open-registration>Đăng ký tư vấn</button>
                <a class="button button--secondary" href="#quyen-loi">Xem quyền lợi</a>
            </div>
        </div>
    </div>
</section>

<?php if ($site['features']['countdown'] ?? false): ?>
<section class="countdown-strip" aria-labelledby="countdown-title">
    <div class="container countdown-strip__inner">
        <h2 id="countdown-title">Đăng Ký Ngay<br><strong>Nhận Xe Điện Trong Ngày</strong></h2>
        <div class="countdown" data-countdown data-duration="<?= e((string) $site['features']['countdown_seconds']) ?>">
            <div><strong data-hours>08</strong><span>Giờ</span></div>
            <b aria-hidden="true">:</b>
            <div><strong data-minutes>00</strong><span>Phút</span></div>
            <b aria-hidden="true">:</b>
            <div><strong data-seconds>00</strong><span>Giây</span></div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require BASE_PATH . '/app/views/components/inline-registration.php'; ?>

<section class="participation section" aria-labelledby="participation-title">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Lựa chọn phù hợp</p>
            <h2 id="participation-title">Bạn muốn tham gia theo hình thức nào?</h2>
        </div>
        <div class="participation-list">
            <?php foreach ($participationOptions as $option): ?>
                <article class="participation-card">
                    <img src="<?= e(asset($option['image'])) ?>" width="<?= e((string) $option['image_width']) ?>" height="<?= e((string) $option['image_height']) ?>" loading="lazy" decoding="async" alt="Minh họa <?= e($option['title']) ?>">
                    <div class="participation-card__content">
                        <div>
                            <h3><?= e($option['title']) ?></h3>
                            <p><?= e($option['description']) ?></p>
                        </div>
                        <button
                            class="button button--secondary button--full"
                            type="button"
                            data-open-participation
                            data-option="<?= e($option['key']) ?>"
                        >Xem chi tiết</button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require BASE_PATH . '/app/views/components/benefits.php'; ?>

<?php require BASE_PATH . '/app/views/components/documents.php'; ?>

<?php require BASE_PATH . '/app/views/components/process.php'; ?>

<?php require BASE_PATH . '/app/views/components/stories.php'; ?>

<?php require BASE_PATH . '/app/views/components/faq.php'; ?>

<dialog class="modal participation-modal" id="participation-modal" aria-labelledby="participation-modal-title">
    <div class="modal__header modal__header--bike-detail">
        <div>
            <p class="eyebrow">Chi tiết hình thức</p>
            <h2 id="participation-modal-title" data-participation-title>Hình thức tham gia</h2>
        </div>
        <button class="modal__close" type="button" aria-label="Đóng thông tin" data-close-modal>×</button>
    </div>
    <div class="modal__body participation-modal__body">
        <section class="participation-overview">
            <h3>Loại hình này là gì?</h3>
            <p data-participation-intro></p>
            <ul class="participation-highlights" data-participation-highlights></ul>
        </section>

        <div class="participation-tabs" role="tablist" aria-label="Thông tin chi tiết hình thức tham gia">
            <button type="button" role="tab" aria-selected="true" data-participation-tab="policies">Chính sách</button>
            <button type="button" role="tab" aria-selected="false" data-participation-tab="process">Quy trình</button>
            <button type="button" role="tab" aria-selected="false" data-participation-tab="faqs">Hỏi đáp</button>
        </div>
        <div class="participation-tab-panel" role="tabpanel" data-participation-panel></div>
    </div>
    <div class="participation-modal__footer">
        <button class="button button--full" type="button" data-select-participation>Đăng ký hình thức này</button>
    </div>
</dialog>

<script type="application/json" id="participation-data"><?= json_encode($participationOptions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>

