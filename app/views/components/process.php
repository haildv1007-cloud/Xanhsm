<?php
declare(strict_types=1);
?>
<section class="process section" aria-labelledby="process-title">
    <div class="container">
        <div class="section-heading section-heading--center">
            <p class="eyebrow">Từng bước rõ ràng</p>
            <h2 id="process-title">4 bước đăng ký</h2>
        </div>
        <ol class="process-list">
            <?php foreach ($page['steps'] as $index => $step): ?>
                <li>
                    <span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <h3><?= e($step['title']) ?></h3>
                    <p><?= e($step['description']) ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
