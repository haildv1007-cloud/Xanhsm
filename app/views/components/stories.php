<?php
declare(strict_types=1);
?>
<section class="stories section" aria-labelledby="stories-title">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Góc chia sẻ</p>
            <h2 id="stories-title">Chia sẻ của tài xế</h2>
            <?php if (!empty($page['stories_note'])): ?><p><?= e($page['stories_note']) ?></p><?php endif; ?>
        </div>
        <div class="story-carousel" data-carousel>
            <div class="story-track" data-carousel-track>
                <?php foreach ($page['stories'] as $index => $story): ?>
                    <button class="story-card" type="button" data-story-card data-open-story-image data-image="<?= e(asset($story['image'])) ?>" data-alt="<?= e($story['alt']) ?>">
                        <img src="<?= e(asset($story['image'])) ?>" width="<?= (int) $story['width'] ?>" height="<?= (int) $story['height'] ?>" loading="lazy" decoding="async" alt="<?= e($story['alt']) ?>">
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-controls">
                <button type="button" data-carousel-prev aria-label="Chia sẻ trước">←</button>
                <span><strong data-carousel-current>1</strong> / <?= count($page['stories']) ?></span>
                <button type="button" data-carousel-next aria-label="Chia sẻ tiếp theo">→</button>
            </div>
        </div>
    </div>
</section>
