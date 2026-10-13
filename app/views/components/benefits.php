<?php
declare(strict_types=1);
?>
<section class="benefits section" id="quyen-loi" aria-labelledby="benefits-title">
    <div class="container">
        <div class="section-heading section-heading--center">
            <p class="eyebrow">Thông tin nổi bật</p>
            <h2 id="benefits-title"><?= e($page['benefits_title'] ?? 'Quyền lợi dành cho tài xế Bike') ?></h2>
        </div>
        <div class="benefit-grid">
            <?php foreach ($page['benefits'] as $benefit): ?>
                <article class="benefit-card">
                    <div class="icon-box"><?= content_icon($benefit['icon']) ?></div>
                    <div>
                        <h3><?= e($benefit['title']) ?></h3>
                        <p><?= e($benefit['description']) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
