<?php

declare(strict_types=1);

return [
    // RTO identifies the participation type, but not a vehicle.
    'page_defaults' => [
        'bike' => ['vehicle' => 'electric-bike'],
        'rto' => ['cooperation_type' => 'rto'],
        'van' => ['vehicle' => 'van'],
    ],
    'fields' => [
        'full_name' => ['label' => 'Họ và tên', 'type' => 'text', 'required' => true],
        'phone' => ['label' => 'Số điện thoại', 'type' => 'tel', 'required' => true],
        'zalo' => ['label' => 'Số Zalo', 'type' => 'tel', 'required' => false],
        'citizen_id' => ['label' => 'Số CCCD', 'type' => 'text', 'required' => false],
        'region' => ['label' => 'Khu vực đăng ký', 'type' => 'select', 'required' => true],
        'vehicle' => ['label' => 'Phương tiện', 'type' => 'select', 'required' => true],
        'cooperation_type' => ['label' => 'Loại hình', 'type' => 'select', 'required' => true],
    ],
    'options' => [
        'regions' => [
            'ha-noi' => 'Hà Nội',
            'ho-chi-minh' => 'Hồ Chí Minh',
            'da-nang' => 'Đà Nẵng',
            'dong-nai' => 'Đồng Nai',
            'binh-duong' => 'Bình Dương',
            'nha-trang' => 'Nha Trang',
            'quang-ninh' => 'Quảng Ninh',
            'vung-tau' => 'Vũng Tàu',
            'vinh' => 'Vinh',
            'hue' => 'Huế',
            'hai-phong' => 'Hải Phòng',
            'thai-nguyen' => 'Thái Nguyên',
            'bac-ninh' => 'Bắc Ninh',
            'thanh-hoa' => 'Thanh Hoá',
            'long-an' => 'Long An',
            'tay-ninh' => 'Tây Ninh',
            'can-tho' => 'Cần Thơ',
        ],
        'vehicles' => [
            'electric-bike' => 'Xe máy điện',
            'electric-car' => 'Ô tô điện',
            'van' => 'Xe van',
        ],
        'cooperation_types' => [
            'company' => 'Chạy xe công ty — chưa có xe',
            'platform' => 'Platform — có xe sẵn',
            'rto' => 'RTO — thuê xe sở hữu',
        ],
    ],
    'rate_limit' => ['attempts' => 5, 'minutes' => 10],
];
