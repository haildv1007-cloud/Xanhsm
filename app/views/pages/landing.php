<?php

declare(strict_types=1);
?>
<section class="hero">
    <div class="container hero__grid">
        <div class="hero__content">
            <p class="eyebrow"><?= e($page['eyebrow']) ?></p>
            <h1><?= e($page['title']) ?></h1>
            <p class="hero__description"><?= e($page['description']) ?></p>
            <div class="hero__actions">
                <a class="button" href="#dang-ky">Đăng ký ngay</a>
                <a class="text-link" href="#thong-tin">Xem thông tin <span aria-hidden="true">→</span></a>
            </div>
        </div>

        <div class="hero__visual" aria-label="Khu vực hình ảnh <?= e($page['nav_label']) ?>">
            <div class="hero__visual-card">
                <span><?= e($page['nav_label']) ?></span>
                <strong>Nội dung trực quan sẽ được hoàn thiện ở giai đoạn giao diện.</strong>
            </div>
        </div>
    </div>
</section>

<section class="foundation" id="dang-ky" aria-labelledby="foundation-title">
    <div class="container foundation__grid">
        <div>
            <p class="eyebrow">Nền tảng dùng chung</p>
            <h2 id="foundation-title">Khung trang đã sẵn sàng cho nội dung và biểu mẫu</h2>
            <p>Giai đoạn này thiết lập cấu trúc, định tuyến và hệ thống trình bày. Form đăng ký thật sẽ được nối database ở giai đoạn backend.</p>
        </div>
        <div class="foundation__cards" id="thong-tin">
            <article class="foundation-card">
                <span>01</span>
                <h3>Mobile-first</h3>
                <p>Khoảng cách, chữ và thành phần được tổ chức từ màn hình nhỏ trước.</p>
            </article>
            <article class="foundation-card">
                <span>02</span>
                <h3>Dùng chung</h3>
                <p>Header, footer, cấu hình và layout không bị sao chép giữa bốn trang.</p>
            </article>
        </div>
    </div>
</section>
