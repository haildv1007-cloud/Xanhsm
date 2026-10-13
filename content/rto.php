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
        'description' => 'RTO cho phép bạn thuê xe để vận doanh trước, sau đó có cơ hội mua lại xe theo chính sách của chương trình.',
        'audience' => 'Phù hợp với người chưa có phương tiện và muốn có xe để chủ động công việc lâu dài.',
        'difference' => 'Chạy xe công ty sử dụng xe được bố trí. Platform dành cho người đã có xe. RTO dành cho người chưa có xe và muốn hướng tới sở hữu phương tiện.',
    ],
    'benefits_title' => 'Điểm nổi bật của hình thức RTO',
    'benefits' => [
        ['icon' => 'car', 'title' => 'Có xe để bắt đầu', 'description' => 'Bạn thuê phương tiện để chạy xe, không cần sở hữu xe từ trước hoặc mua xe ngay.'],
        ['icon' => 'document', 'title' => 'Có hướng mua lại xe', 'description' => 'Sau thời gian thuê và khi đáp ứng chính sách, tài xế có thể mua lại xe với giá ưu đãi.'],
        ['icon' => 'calendar', 'title' => 'Khoản thuê theo kỳ', 'description' => 'Tiền thuê, tiền cọc và thời hạn thuê là các khoản riêng cần nắm rõ trước khi nhận xe.'],
        ['icon' => 'support', 'title' => 'Có phương án mua trước hạn', 'description' => 'Chương trình cũng có cơ chế mua lại xe trước hạn theo giá và điều kiện áp dụng.'],
    ],
    'documents_title' => 'Giấy tờ cần chuẩn bị',
    'documents_intro' => 'Để tìm hiểu phương án thuê xe, bạn có thể chuẩn bị trước:',
    'documents' => [
        ['title' => 'CCCD / Hộ chiếu', 'description' => 'Giấy tờ nhận diện cá nhân còn hiệu lực.'],
        ['title' => 'Giấy phép lái xe đang có', 'description' => 'Mang theo bằng phù hợp với loại xe bạn muốn sử dụng.'],
    ],
    'steps' => [
        ['title' => 'Đăng ký nhu cầu', 'description' => 'Chọn RTO, khu vực và loại xe bạn quan tâm.'],
        ['title' => 'Xem phương án thuê', 'description' => 'Nắm khoản thuê, tiền cọc, thời hạn và cách mua lại xe trước khi quyết định.'],
        ['title' => 'Hoàn tất đăng ký', 'description' => 'Chuẩn bị giấy tờ và hoàn tất thủ tục thuê xe phù hợp.'],
        ['title' => 'Nhận xe để vận doanh', 'description' => 'Làm quen phương tiện, ứng dụng và bắt đầu chạy xe.'],
    ],
    'stories' => require __DIR__ . '/driver-stories.php',
    'stories_note' => 'Những chia sẻ thực tế giúp bạn hình dung thêm về hành trình làm tài xế.',
    'faqs' => [
        ['question' => 'RTO là hình thức gì?', 'answer' => 'Bạn thuê xe để vận doanh trước. Sau thời gian thuê và khi đáp ứng chính sách, bạn có thể mua lại xe với giá ưu đãi; chương trình cũng có phương án mua trước hạn.'],
        ['question' => 'RTO khác chạy xe công ty như thế nào?', 'answer' => 'Chạy xe công ty sử dụng xe được bố trí. RTO dành cho người muốn thuê xe và hướng tới sở hữu phương tiện.'],
        ['question' => 'Tôi đã có xe thì có phù hợp với RTO không?', 'answer' => 'Nếu muốn chạy bằng xe mình đang sở hữu, Platform là hình thức phù hợp hơn. RTO dành cho người muốn thuê xe để vận doanh và hướng tới mua lại xe.'],
        ['question' => 'RTO áp dụng cho phương tiện nào?', 'answer' => 'Chương trình thuê xe máy điện đã được công bố cho các dòng VinFast Evo200 và Feliz II. Bạn có thể chọn phương tiện quan tâm trong biểu mẫu; việc áp dụng thực tế phụ thuộc chương trình tại khu vực.'],
        ['question' => 'Các khoản thuê và kỳ hạn được tính thế nào?', 'answer' => 'RTO có khoản thuê định kỳ, khoản cọc và thời hạn thuê. Sau thời gian thuê đủ điều kiện, bạn có thể mua lại xe theo chính sách; chương trình cũng có phương án mua trước hạn. Mức tiền phụ thuộc loại xe và chính sách hiện hành.'],
        ['question' => 'Sau khi đăng ký tôi cần làm gì?', 'answer' => 'Bạn sẽ được liên hệ và hướng dẫn giấy tờ cùng các bước tiếp theo.'],
    ],
    'seo' => [
        'title' => 'Đăng ký RTO | Thuê xe hướng tới sở hữu',
        'description' => 'Tìm hiểu hình thức thuê xe hướng tới sở hữu, giấy tờ và các bước đăng ký RTO.',
    ],
];
