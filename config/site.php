<?php

declare(strict_types=1);

return [
    'name' => 'Đăng ký tài xế Xanh SM',
    'url' => rtrim((string) env('APP_URL', ''), '/'),
    'language' => 'vi',
    'theme_color' => '#00CED3',
    'contact' => [
        'phone' => '',
        'zalo_url' => '',
    ],
    'features' => [
        'support_bubble' => true,
        'countdown' => true,
        'countdown_seconds' => 28800,
        'countdown_mode' => 'session_preview',
    ],
    'gtm_id' => (string) env('GTM_ID', ''),
    'success_path' => '/dang-ky-thanh-cong',
];
