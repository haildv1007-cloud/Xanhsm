<?php

declare(strict_types=1);

return [
    'slug' => 'bike',
    'route' => '/',
    'nav_label' => 'Bike',
    'eyebrow' => 'Xanh SM Bike',
    'title' => 'Đăng ký đồng hành cùng Xanh SM Bike',
    'description' => 'Tìm hiểu hình thức tham gia phù hợp và để lại thông tin đăng ký',
    'hero_image' => 'assets/images/hero-section/bike.webp',
    'hero_image_width' => 1672,
    'hero_image_height' => 941,
    'benefits' => [
        [
            'icon' => 'support',
            'title' => 'Hỗ trợ 24/7',
            'description' => 'Đồng hành trong quá trình đăng ký và vận hành.',
        ],
        [
            'icon' => 'calendar',
            'title' => 'Nhận xe điện nhanh',
            'description' => 'Hướng dẫn nhận xe theo lịch tiếp nhận tại khu vực.',
        ],
        [
            'icon' => 'document',
            'title' => 'Đồng phục & trang bị',
            'description' => 'Cấp phát theo chính sách của chương trình đang áp dụng.',
        ],
        [
            'icon' => 'chart',
            'title' => 'Hỗ trợ phúc lợi',
            'description' => 'Lương cứng và bảo hiểm tùy hình thức, khu vực tiếp nhận.',
        ],
        [
            'icon' => 'calendar',
            'title' => 'Chủ động thời gian',
            'description' => 'Lựa chọn phương án vận hành phù hợp với nhu cầu.',
        ],
        [
            'icon' => 'support',
            'title' => 'Cộng đồng tài xế',
            'description' => 'Kết nối và hỗ trợ trong quá trình hoạt động.',
        ],
    ],
    'participation_options' => [
        [
            'key' => 'company',
            'title' => 'Chạy xe công ty',
            'description' => 'Dành cho bạn chưa có xe',
            'image' => 'assets/images/bike-company.webp',
            'image_width' => 900,
            'image_height' => 500,
            'intro' => 'Phương án dành cho người chưa có xe. Bạn được hướng dẫn nhận phương tiện và bắt đầu hoạt động theo quy trình đơn giản.',
            'highlights' => [
                'Chưa cần có xe sẵn',
                'Phương tiện do chương trình bố trí',
                'Được hướng dẫn kích hoạt và vận hành',
                'Được hướng dẫn từ lúc đăng ký',
            ],
            'policies' => [
                ['label' => 'Phương tiện', 'value' => 'Được chương trình bố trí'],
                ['label' => 'Dành cho', 'value' => 'Người chưa có xe'],
                ['label' => 'Bắt đầu hoạt động', 'value' => 'Có người hướng dẫn từng bước'],
                ['label' => 'Trang bị hỗ trợ', 'value' => 'Được tư vấn khi đăng ký'],
            ],
            'process' => [
                ['title' => 'Đăng ký thông tin', 'description' => 'Chọn hình thức chạy xe công ty trong biểu mẫu.'],
                ['title' => 'Nhận hướng dẫn', 'description' => 'Trao đổi khu vực, lịch nhận xe và giấy tờ cần chuẩn bị.'],
                ['title' => 'Chuẩn bị thông tin', 'description' => 'Tư vấn viên hỗ trợ bạn hoàn thành các bước cần thiết.'],
                ['title' => 'Nhận xe và vận hành', 'description' => 'Thực hiện thủ tục nhận xe và kích hoạt tài khoản.'],
            ],
            'faqs' => [
                ['question' => 'Chưa có xe có đăng ký được không?', 'answer' => 'Có. Đây là hình thức dành cho người chưa có phương tiện.'],
                ['question' => 'Xe được bố trí như thế nào?', 'answer' => 'Mẫu xe và lịch nhận xe sẽ được tư vấn theo khu vực bạn đăng ký.'],
                ['question' => 'Cần chuẩn bị giấy tờ gì?', 'answer' => 'Thông thường gồm giấy tờ định danh, giấy phép lái xe và hồ sơ bổ sung theo hướng dẫn.'],
            ],
        ],
        [
            'key' => 'platform',
            'title' => 'Platform',
            'description' => 'Dành cho bạn đã có xe',
            'image' => 'assets/images/bike-platform.webp',
            'image_width' => 1920,
            'image_height' => 1279,
            'intro' => 'Phương án dành cho người đã có xe máy điện và muốn sử dụng chính phương tiện của mình để tham gia hoạt động.',
            'highlights' => [
                'Sử dụng xe đang sở hữu',
                'Chủ động phương tiện hằng ngày',
                'Được hướng dẫn kết nối xe và tài khoản',
                'Theo dõi hoạt động trên ứng dụng',
            ],
            'policies' => [
                ['label' => 'Phương tiện', 'value' => 'Sử dụng xe của bạn'],
                ['label' => 'Dành cho', 'value' => 'Người đã có xe máy điện'],
                ['label' => 'Bắt đầu hoạt động', 'value' => 'Được hướng dẫn kết nối tài khoản'],
                ['label' => 'Mức độ chủ động', 'value' => 'Chủ động phương tiện và thời gian'],
            ],
            'process' => [
                ['title' => 'Đăng ký thông tin', 'description' => 'Chọn Platform và khai báo phương tiện đang có.'],
                ['title' => 'Nhận tư vấn', 'description' => 'Trao đổi dòng xe, khu vực và cách tham gia.'],
                ['title' => 'Kết nối phương tiện', 'description' => 'Được hướng dẫn cập nhật thông tin xe và tài khoản.'],
                ['title' => 'Bắt đầu hoạt động', 'description' => 'Làm quen với ứng dụng và chủ động thời gian chạy.'],
            ],
            'faqs' => [
                ['question' => 'Tôi đang có xe thì bắt đầu thế nào?', 'answer' => 'Bạn chọn Platform, để lại dòng xe và khu vực để được hướng dẫn các bước tiếp theo.'],
                ['question' => 'Tôi có được chủ động sử dụng xe không?', 'answer' => 'Có. Đây là hình thức sử dụng xe của bạn và chủ động phương tiện hằng ngày.'],
                ['question' => 'Platform khác chạy xe công ty thế nào?', 'answer' => 'Platform sử dụng xe của tài xế; chạy xe công ty sử dụng xe được chương trình bố trí.'],
            ],
        ],
        [
            'key' => 'rto',
            'title' => 'Thuê xe sở hữu',
            'description' => 'Tìm hiểu phương án RTO',
            'image' => 'assets/images/bike-rto.webp',
            'image_width' => 600,
            'image_height' => 400,
            'intro' => 'Phương án thuê xe hướng tới sở hữu. Bạn nhận xe để hoạt động, thanh toán theo kỳ và từng bước tiến tới sở hữu phương tiện.',
            'highlights' => [
                'Không cần mua xe ngay từ đầu',
                'Có lộ trình hướng tới sở hữu',
                'Lộ trình rõ theo mẫu xe lựa chọn',
                'Được hướng dẫn trước khi nhận xe',
            ],
            'policies' => [
                ['label' => 'Hình thức', 'value' => 'Thuê xe hướng tới sở hữu'],
                ['label' => 'Dành cho', 'value' => 'Người muốn có lộ trình sở hữu xe'],
                ['label' => 'Cách tham gia', 'value' => 'Chọn mẫu xe và kỳ hạn phù hợp'],
                ['label' => 'Sau lộ trình', 'value' => 'Hướng tới sở hữu phương tiện'],
            ],
            'process' => [
                ['title' => 'Đăng ký nhu cầu', 'description' => 'Chọn RTO và khu vực muốn tham gia.'],
                ['title' => 'Chọn phương án xe', 'description' => 'Trao đổi mẫu xe, kỳ hạn và cách tham gia.'],
                ['title' => 'Hoàn thành đăng ký', 'description' => 'Được hướng dẫn thông tin và các bước nhận xe.'],
                ['title' => 'Nhận xe và hoạt động', 'description' => 'Nhận xe theo lịch và thực hiện lộ trình đã lựa chọn.'],
            ],
            'faqs' => [
                ['question' => 'RTO khác chạy xe công ty thế nào?', 'answer' => 'RTO có lộ trình hướng tới sở hữu; xe công ty được bố trí để vận hành theo chương trình.'],
                ['question' => 'Tôi chọn mẫu xe và kỳ hạn thế nào?', 'answer' => 'Tư vấn viên sẽ giới thiệu các phương án đang có để bạn lựa chọn theo nhu cầu.'],
                ['question' => 'Khi nào tôi tiến tới sở hữu xe?', 'answer' => 'Mốc sở hữu phụ thuộc lộ trình của phương án bạn lựa chọn và sẽ được trình bày khi tư vấn.'],
            ],
        ],
    ],
    'documents_intro' => 'Danh sách giấy tờ tham khảo để bạn chuẩn bị trước khi đến văn phòng.',
    'documents' => [
        ['title' => 'CCCD/ Hộ Chiếu', 'description' => ''],
        ['title' => 'Bằng Lái Xe (A1/A2) Chấp Nhận Trên VNEID/ VNETRAFFIC', 'description' => ''],
        ['title' => 'LLTP ( tại văn phòng có hỗ trợ làm ), có thể thay thế bằng Sơ Yếu Lý Lịch', 'description' => ''],
    ],
    'steps' => [
        ['title' => 'Để lại thông tin', 'description' => 'Điền đầy đủ các trường trong biểu mẫu đăng ký.'],
        ['title' => 'Nhận tư vấn', 'description' => 'Trao đổi hình thức và khu vực phù hợp với nhu cầu.'],
        ['title' => 'Chuẩn bị hồ sơ', 'description' => 'Hoàn thiện giấy tờ theo danh sách đã được hướng dẫn.'],
        ['title' => 'Hoàn tất thủ tục', 'description' => 'Thực hiện các bước tiếp theo theo lịch được hướng dẫn.'],
    ],
    'stories' => require __DIR__ . '/driver-stories.php',
    'faqs' => [
        [
            'question' => 'Chưa có xe có thể đăng ký không?',
            'answer' => 'Bạn có thể chọn “Chạy xe công ty — chưa có xe” hoặc tìm hiểu phương án RTO. Khả năng tiếp nhận phụ thuộc khu vực và chương trình tại thời điểm tư vấn.',
        ],
        [
            'question' => 'Đã có xe thì chọn hình thức nào?',
            'answer' => 'Bạn có thể chọn Platform. Tư vấn viên sẽ hướng dẫn cách tham gia theo loại xe và khu vực đăng ký.',
        ],
        [
            'question' => 'Cần chuẩn bị những giấy tờ gì?',
            'answer' => 'Danh sách cơ bản gồm giấy tờ định danh và giấy phép lái xe phù hợp. Tư vấn viên sẽ hướng dẫn phần còn lại khi liên hệ.',
        ],
        [
            'question' => 'Thu nhập được tính như thế nào?',
            'answer' => 'Thông tin thu nhập chỉ mang tính tham khảo và phụ thuộc khu vực, thời gian hoạt động, hình thức tham gia cùng chính sách đang áp dụng.',
        ],
    ],
    'seo' => [
        'title' => 'Đăng ký tài xế Bike | Nhận tư vấn',
        'description' => 'Tìm hiểu hình thức tham gia, giấy tờ và các bước đăng ký tài xế Bike.',
    ],
];
