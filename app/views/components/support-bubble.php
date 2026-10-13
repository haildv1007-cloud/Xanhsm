<?php

declare(strict_types=1);

if (!($site['features']['support_bubble'] ?? false)) {
    return;
}

$phone = trim((string) ($site['contact']['phone'] ?? ''));
$zaloUrl = trim((string) ($site['contact']['zalo_url'] ?? ''));
?>
<aside class="support-widget" data-support-widget>
    <div class="support-widget__actions" id="support-actions" hidden>
        <?php if ($phone !== ''): ?>
            <a href="tel:<?= e($phone) ?>">Gọi tư vấn</a>
        <?php else: ?>
            <button type="button" disabled>Gọi tư vấn</button>
        <?php endif; ?>
        <?php if ($zaloUrl !== ''): ?>
            <a href="<?= e($zaloUrl) ?>" target="_blank" rel="noopener">Zalo</a>
        <?php else: ?>
            <button type="button" disabled>Zalo</button>
        <?php endif; ?>
    </div>
    <button class="support-widget__trigger" type="button" aria-expanded="false" aria-controls="support-actions" data-support-toggle>
        <span aria-hidden="true">☎</span>
        <span>Hỗ trợ</span>
    </button>
</aside>
