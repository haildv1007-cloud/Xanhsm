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
        'description' => 'RTO là hình thức thuê xe điện để chạy và từng bước sở hữu chính chiếc xe đang sử dụng.',
        'audience' => 'Phù hợp với người chưa có phương tiện và muốn có xe để chủ động công việc lâu dài.',
        'difference' => 'Chạy xe công ty sử dụng xe công ty. Platform dành cho người đã có xe. RTO dành cho người chưa có xe và muốn hướng tới sở hữu phương tiện.',
    ],
    'benefits_title' => 'Quyền lợi của tài xế',
    'benefits' => [
        ['icon' => 'car', 'title' => 'Chạy xe, sở hữu xe điện', 'description' => 'Vừa chạy xe tạo thu nhập, vừa tiến tới sở hữu chính chiếc xe điện bạn đang sử dụng theo chính sách RTO.'],
        ['icon' => 'uniform', 'title' => 'Miễn phí đồng phục, nhận xe điện', 'description' => 'Nhận đồng phục miễn phí và xe máy điện để bắt đầu công việc theo chương trình RTO.'],
        ['icon' => 'support', 'title' => 'Hỗ trợ 24/7', 'description' => 'Có đội ngũ đồng hành khi bạn cần hỗ trợ trong quá trình chạy xe.'],
        ['icon' => 'document', 'title' => 'Hồ sơ nhanh, nhận xe nhanh', 'description' => 'Hoàn tất các bước đăng ký gọn; sau khi hồ sơ được kích hoạt, bạn có thể nhận xe để bắt đầu chạy.'],
    ],
    'documents_title' => 'Giấy tờ cần chuẩn bị',
    'documents_intro' => 'Để tìm hiểu phương án thuê xe, bạn có thể chuẩn bị trước:',
    'documents' => [
        ['title' => 'CCCD / Hộ chiếu', 'description' => 'Giấy tờ nhận diện cá nhân còn hiệu lực.'],
        ['title' => 'Giấy phép lái xe đang có', 'description' => 'Mang theo bằng phù hợp với loại xe bạn muốn sử dụng.'],
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
        ['question' => 'RTO khác chạy xe công ty như thế nào?', 'answer' => 'Chạy xe công ty sử dụng xe công ty. RTO dành cho người muốn thuê xe và hướng tới sở hữu phương tiện.'],
        ['question' => 'Tôi đã có xe thì có phù hợp với RTO không?', 'answer' => 'Nếu muốn sử dụng xe đang sở hữu, bạn chọn Platform. RTO phù hợp với người chưa có xe và muốn hướng tới sở hữu phương tiện.'],
        ['question' => 'RTO áp dụng cho phương tiện nào?', 'answer' => 'Bạn chọn phương tiện phù hợp với nhu cầu trong biểu mẫu đăng ký. Các mẫu xe hiện có phụ thuộc khu vực và chương trình.'],
        ['question' => 'Các khoản thuê và kỳ hạn được tính thế nào?', 'answer' => 'Mức thuê và kỳ hạn phụ thuộc mẫu xe cùng phương án bạn lựa chọn. Thông tin cụ thể được trình bày trước khi bạn hoàn tất đăng ký.'],
        ['question' => 'Sau khi đăng ký tôi cần làm gì?', 'answer' => 'Chuẩn bị giấy tờ theo danh sách và hoàn tất các bước nhận xe theo lịch đã chọn.'],
    ],
    'seo' => [
        'title' => 'Đăng ký RTO | Thuê xe hướng tới sở hữu',
        'description' => 'Tìm hiểu hình thức thuê xe hướng tới sở hữu, giấy tờ và các bước đăng ký RTO.',
    ],
];
