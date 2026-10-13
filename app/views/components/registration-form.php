<?php

declare(strict_types=1);

$formInstance = $formInstance ?? 'inline';
$formPrefix = 'registration-' . $formInstance;
$formDefaults = $form['page_defaults'][$page['slug'] ?? ''] ?? [];
$required = static fn (string $field): bool => (bool) ($form['fields'][$field]['required'] ?? false);
?>
<form class="registration-form" data-registration-form data-form-location="<?= e($formInstance) ?>" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="submission_token" value="<?= e($submissionToken) ?>">
    <input type="hidden" name="source_page" value="<?= e($page['slug'] ?? '') ?>">
    <input type="hidden" name="form_location" value="<?= e($formInstance) ?>">
    <input type="hidden" name="source_url" value="">
    <input type="hidden" name="utm_source" value="">
    <input type="hidden" name="utm_medium" value="">
    <input type="hidden" name="utm_campaign" value="">
    <input type="hidden" name="utm_content" value="">
    <input type="hidden" name="utm_term" value="">
    <input type="hidden" name="click_id" value="">
    <div class="honeypot" aria-hidden="true">
        <label for="<?= e($formPrefix) ?>-website">Website</label>
        <input id="<?= e($formPrefix) ?>-website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>
    <div class="form-grid">
        <div class="field field--wide">
            <label for="<?= e($formPrefix) ?>-full-name">Họ và tên</label>
            <input id="<?= e($formPrefix) ?>-full-name" name="full_name" type="text" autocomplete="name" maxlength="100" placeholder="Nhập họ và tên" <?= $required('full_name') ? 'required aria-required="true"' : '' ?>>
            <span class="field-error" data-field-error="full_name"></span>
        </div>

        <div class="field">
            <label for="<?= e($formPrefix) ?>-phone">Số điện thoại</label>
            <input id="<?= e($formPrefix) ?>-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" maxlength="20" placeholder="Nhập số điện thoại" <?= $required('phone') ? 'required aria-required="true"' : '' ?>>
            <span class="field-error" data-field-error="phone"></span>
        </div>

        <div class="field">
            <label for="<?= e($formPrefix) ?>-zalo">Số Zalo</label>
            <input id="<?= e($formPrefix) ?>-zalo" name="zalo" type="tel" inputmode="tel" maxlength="20" placeholder="Nhập số Zalo">
            <span class="field-error" data-field-error="zalo"></span>
            <label class="check-option">
                <input type="checkbox" data-zalo-same-phone>
                <span>Zalo dùng cùng số điện thoại</span>
            </label>
        </div>

        <div class="field">
            <label for="<?= e($formPrefix) ?>-citizen-id">Số CCCD</label>
            <input id="<?= e($formPrefix) ?>-citizen-id" name="citizen_id" type="text" inputmode="numeric" autocomplete="off" maxlength="12" placeholder="Nhập số CCCD">
            <span class="field-error" data-field-error="citizen_id"></span>
        </div>

        <div class="field">
            <label for="<?= e($formPrefix) ?>-region">Khu vực đăng ký</label>
            <select id="<?= e($formPrefix) ?>-region" name="region" <?= $required('region') ? 'required aria-required="true"' : '' ?>>
                <option value="">Chọn khu vực</option>
                <?php foreach ($form['options']['regions'] as $value => $label): ?>
                    <option value="<?= e($value) ?>"><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="field-error" data-field-error="region"></span>
        </div>

        <div class="field">
            <label for="<?= e($formPrefix) ?>-vehicle">Phương tiện</label>
            <select id="<?= e($formPrefix) ?>-vehicle" name="vehicle" <?= $required('vehicle') ? 'required aria-required="true"' : '' ?>>
                <option value="">Chọn phương tiện</option>
                <?php foreach ($form['options']['vehicles'] as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= $value === ($formDefaults['vehicle'] ?? '') ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="field-error" data-field-error="vehicle"></span>
        </div>

        <div class="field field--wide">
            <label for="<?= e($formPrefix) ?>-cooperation-type">Hình thức tham gia</label>
            <select id="<?= e($formPrefix) ?>-cooperation-type" name="cooperation_type" data-cooperation-select <?= $required('cooperation_type') ? 'required aria-required="true"' : '' ?>>
                <option value="">Chọn hình thức</option>
                <?php foreach ($form['options']['cooperation_types'] as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= $value === ($formDefaults['cooperation_type'] ?? '') ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="field-error" data-field-error="cooperation_type"></span>
        </div>
    </div>

    <p class="form-consent">Khi gửi thông tin, bạn đồng ý với <button type="button" data-open-legal>Chính sách bảo mật &amp; Điều khoản sử dụng</button>.</p>
    <button class="button button--full" type="submit" data-submit-registration>Đăng ký nhận tư vấn</button>
    <p class="form-status" role="status" aria-live="polite" tabindex="-1" hidden></p>
</form>
