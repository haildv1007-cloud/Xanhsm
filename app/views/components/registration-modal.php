<?php
declare(strict_types=1);
?>
<dialog class="modal registration-modal" id="registration-modal" aria-labelledby="registration-modal-title">
    <div class="modal__header">
        <div>
            <p class="eyebrow">Biểu mẫu đăng ký</p>
            <h2 id="registration-modal-title">Đăng ký nhận tư vấn</h2>
        </div>
        <button class="modal__close" type="button" aria-label="Đóng biểu mẫu" data-close-modal>×</button>
    </div>
    <div class="modal__body">
        <?php $formInstance = 'modal'; require BASE_PATH . '/app/views/components/registration-form.php'; ?>
    </div>
</dialog>
