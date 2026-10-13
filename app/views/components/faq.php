<?php
declare(strict_types=1);
?>
<section class="faq section" aria-labelledby="faq-title">
    <div class="container faq__grid">
        <div class="section-heading">
            <p class="eyebrow">Bạn cần biết thêm?</p>
            <h2 id="faq-title">Câu hỏi thường gặp</h2>
            <button class="button" type="button" data-open-registration>Đăng ký tư vấn</button>
        </div>
        <div class="faq-list">
            <?php foreach ($page['faqs'] as $index => $faq): ?>
                <details <?= $index === 0 ? 'open' : '' ?>>
                    <summary><?= e($faq['question']) ?></summary>
                    <p><?= e($faq['answer']) ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
