<?php

declare(strict_types=1);

return [
    'slug' => 'rto',
    'route' => '/rto',
    'nav_label' => 'RTO',
    'eyebrow' => 'Thuê xe sở hữu',
    'title' => 'Chủ động hành trình cùng RTO',
    'description' => 'Tìm hiểu hình thức thuê xe hướng tới sở hữu phương tiện.',
    'hero_image' => 'assets/images/hero-section/rto.webp',
    'hero_alt' => 'Tài xế Xanh SM đứng cạnh xe máy điện màu cyan và cầm chìa khóa',
    'intro' => [
        'title' => 'RTO là gì?',
        'description' => 'RTO là phương án thuê xe hướng tới sở hữu phương tiện.',
        'audience' => 'Phù hợp với người chưa có phương tiện và muốn có xe để chủ động công việc lâu dài.',
        'difference' => 'Chạy xe công ty sử dụng xe được bố trí. Platform dành cho người đã có xe. RTO dành cho người chưa có xe và muốn hướng tới sở hữu phương tiện.',
    ],
    'benefits_title' => 'Điểm nổi bật của hình thức RTO',
    'benefits' => [
        ['icon' => 'document', 'title' => 'Hướng tới sở hữu phương tiện', 'description' => 'Phương án dành cho người muốn sử dụng xe lâu dài và hướng tới sở hữu.'],
        ['icon' => 'car', 'title' => 'Không cần có xe sẵn', 'description' => 'Bạn có thể tìm hiểu RTO ngay cả khi chưa sở hữu phương tiện.'],
        ['icon' => 'calendar', 'title' => 'Chủ động công việc', 'description' => 'Có phương tiện để bắt đầu và duy trì công việc tài xế ổn định hơn.'],
        ['icon' => 'support', 'title' => 'Được hướng dẫn từng bước', 'description' => 'Nhận hướng dẫn về giấy tờ, phương tiện và cách bắt đầu tham gia.'],
    ],
    'documents_title' => 'Giấy tờ cần chuẩn bị',
    'documents_intro' => 'Bạn sẽ được hướng dẫn danh sách giấy tờ phù hợp trước khi tham gia.',
    'documents' => [
        ['title' => 'Thông tin cá nhân', 'description' => 'Chuẩn bị giấy tờ nhận diện cá nhân theo hướng dẫn khi tư vấn.'],
        ['title' => 'Thông tin bằng lái đang có', 'description' => 'Chia sẻ loại bằng lái để được hướng dẫn theo phương tiện phù hợp.'],
        ['title' => 'Giấy tờ bổ sung', 'description' => 'Chuẩn bị thêm giấy tờ theo danh sách được hướng dẫn.'],
    ],
    'steps' => [
        ['title' => 'Để lại thông tin', 'description' => 'Chọn RTO và gửi thông tin liên hệ của bạn.'],
        ['title' => 'Nhận thông tin', 'description' => 'Tìm hiểu hình thức RTO và loại phương tiện phù hợp.'],
        ['title' => 'Chuẩn bị giấy tờ', 'description' => 'Hoàn thiện giấy tờ theo danh sách được hướng dẫn.'],
        ['title' => 'Bắt đầu tham gia', 'description' => 'Hoàn tất các bước cần thiết và nhận hướng dẫn sử dụng phương tiện.'],
    ],
    'stories' => require __DIR__ . '/driver-stories.php',
    'stories_note' => 'Những chia sẻ thực tế giúp bạn hình dung thêm về hành trình làm tài xế.',
    'faqs' => [
        ['question' => 'RTO là hình thức gì?', 'answer' => 'RTO là hình thức thuê xe hướng tới sở hữu phương tiện.'],
        ['question' => 'RTO khác chạy xe công ty như thế nào?', 'answer' => 'Chạy xe công ty sử dụng xe được bố trí. RTO dành cho người muốn thuê xe và hướng tới sở hữu phương tiện.'],
        ['question' => 'Tôi đã có xe thì có phù hợp với RTO không?', 'answer' => 'Platform là hình thức dành cho người sử dụng xe đang sở hữu. Bạn có thể đăng ký để được hướng dẫn lựa chọn phù hợp.'],
        ['question' => 'RTO áp dụng cho phương tiện nào?', 'answer' => 'Loại phương tiện sẽ được giới thiệu khi liên hệ. Biểu mẫu không chọn sẵn phương tiện để bạn lựa chọn đúng nhu cầu.'],
        ['question' => 'Các khoản thuê và kỳ hạn được tính thế nào?', 'answer' => 'Mức thuê và kỳ hạn sẽ được cung cấp khi tư vấn để bạn cân nhắc trước khi tham gia.'],
        ['question' => 'Sau khi đăng ký tôi cần làm gì?', 'answer' => 'Bạn sẽ được liên hệ và hướng dẫn giấy tờ cùng các bước tiếp theo.'],
    ],
    'seo' => [
        'title' => 'Đăng ký RTO | Thuê xe hướng tới sở hữu',
        'description' => 'Tìm hiểu hình thức thuê xe hướng tới sở hữu, giấy tờ và các bước đăng ký RTO.',
    ],
];
