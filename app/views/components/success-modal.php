<?php

declare(strict_types=1);
?>
<dialog
    class="modal success-modal"
    id="success-modal"
    aria-labelledby="success-modal-title"
    data-success-modal
    data-success-path="<?= e((string) ($site['success_path'] ?? '/dang-ky-thanh-cong')) ?>"
    <?= !empty($showSuccessModal) ? 'data-auto-open' : '' ?>
>
    <div class="modal__header success-modal__header">
        <div class="success-modal__icon" aria-hidden="true">✓</div>
        <button class="modal__close" type="button" aria-label="Đóng thông báo" data-close-modal>×</button>
    </div>
    <div class="modal__body success-modal__body">
        <p class="eyebrow">Đăng ký thành công</p>
        <h2 id="success-modal-title">Đã gửi thông tin tư vấn</h2>
        <p>Thông tin của bạn đã được tiếp nhận. Nhân viên tư vấn sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
        <p class="success-modal__reference" data-success-reference hidden></p>
        <button class="button button--full" type="button" data-close-modal>Đã hiểu</button>
    </div>
</dialog>
