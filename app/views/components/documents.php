<?php
declare(strict_types=1);
?>
<section class="documents section" aria-labelledby="documents-title">
    <div class="container split-section">
        <div class="section-heading">
            <p class="eyebrow">Chuẩn bị trước</p>
            <h2 id="documents-title"><?= e($page['documents_title'] ?? 'Giấy tờ đăng ký') ?></h2>
            <p><?= e($page['documents_intro'] ?? 'Trước lên văn phòng đăng ký, quý đối tác vui lòng chuẩn bị trước các giấy tờ sau đây') ?></p>
        </div>
        <div class="document-list">
            <?php foreach ($page['documents'] as $index => $document): ?>
                <article>
                    <span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <div>
                        <h3><?= e($document['title']) ?></h3>
                        <?php if ($document['description'] !== ''): ?><p><?= e($document['description']) ?></p><?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
