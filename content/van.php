<?php

declare(strict_types=1);

return [
    'slug' => 'van',
    'route' => '/van',
    'nav_label' => 'Van',
    'eyebrow' => 'Xanh SM Van',
    'title' => 'Cùng Xanh SM Van, bắt đầu hành trình mới',
    'description' => 'Tìm hiểu công việc vận hành xe Van và cách tham gia phù hợp.',
    'hero_image' => 'assets/images/hero-section/van.webp',
    'hero_image_width' => 1536,
    'hero_image_height' => 1024,
    'hero_alt' => 'Đội xe Xanh SM Van và các tài xế tại khu vực tập kết',
    'benefits_title' => 'Thông tin dành cho tài xế Van',
    'benefits' => [
        ['icon' => 'car', 'title' => 'Công việc dễ hình dung', 'description' => 'Được giới thiệu cách vận hành xe và công việc ở mức phù hợp với chương trình tại khu vực.'],
        ['icon' => 'support', 'title' => 'Hướng dẫn từng bước', 'description' => 'Được tư vấn từ lúc để lại thông tin đến khi chuẩn bị cho các bước tiếp theo.'],
        ['icon' => 'calendar', 'title' => 'Cách tham gia rõ ràng', 'description' => 'Trao đổi nhu cầu và thời gian dự kiến để nhận hướng dẫn phù hợp.'],
        ['icon' => 'document', 'title' => 'Thông tin theo chương trình', 'description' => 'Thông tin phương tiện, quyền lợi và cách tham gia được tư vấn theo chương trình và khu vực.'],
    ],
    'documents_title' => 'Giấy tờ cần chuẩn bị',
    'documents_intro' => 'Danh sách tham khảo để bạn chuẩn bị trước khi đến văn phòng. Giấy tờ cụ thể được hướng dẫn theo chương trình và khu vực.',
    'documents' => [
        ['title' => 'CCCD / Hộ chiếu', 'description' => ''],
        ['title' => 'Bằng lái xe', 'description' => 'Trao đổi cách sử dụng bằng lái trên VNeID khi tư vấn.'],
        ['title' => 'Lý lịch tư pháp số 2', 'description' => 'Có hỗ trợ tại văn phòng theo hướng dẫn đăng ký.'],
        ['title' => 'Giấy khám sức khỏe người lái xe', 'description' => ''],
    ],
    'steps' => [
        ['title' => 'Để lại thông tin', 'description' => 'Điền thông tin liên hệ và khu vực bạn quan tâm.'],
        ['title' => 'Nhận tư vấn', 'description' => 'Trao đổi khái quát về công việc, phương tiện và cách tham gia.'],
        ['title' => 'Chuẩn bị giấy tờ', 'description' => 'Chuẩn bị theo danh sách được hướng dẫn dành cho bạn.'],
        ['title' => 'Bắt đầu hành trình', 'description' => 'Nhận hướng dẫn các bước tiếp theo theo chương trình và khu vực.'],
    ],
    'stories' => require __DIR__ . '/driver-stories.php',
    'faqs' => [
        ['question' => 'Tài xế Van làm công việc gì?', 'answer' => 'Tài xế vận hành xe Van cho các chuyến giao nhận theo hướng dẫn của chương trình. Nội dung công việc cụ thể được trao đổi khi tư vấn.'],
        ['question' => 'Tôi có phù hợp với công việc này không?', 'answer' => 'Nếu bạn quan tâm đến công việc lái xe và giao nhận, hãy để lại thông tin để được tư vấn cách tham gia phù hợp.'],
        ['question' => 'Phương tiện được chuẩn bị như thế nào?', 'answer' => 'Thông tin phương tiện được hướng dẫn khi liên hệ, theo chương trình và khu vực.'],
        ['question' => 'Cần chuẩn bị giấy tờ gì?', 'answer' => 'Giấy tờ cụ thể được tư vấn theo hình thức tham gia. Bạn có thể đăng ký trước để nhận danh sách phù hợp.'],
        ['question' => 'Khu vực của tôi có thể tham gia không?', 'answer' => 'Chọn khu vực bạn quan tâm trong biểu mẫu; nếu chưa thấy, chọn “Khu vực khác” để được tư vấn.'],
        ['question' => 'Sau khi gửi thông tin, bước tiếp theo là gì?', 'answer' => 'Tư vấn viên sẽ liên hệ để trao đổi nhu cầu và hướng dẫn các bước tiếp theo theo chương trình và khu vực.'],
    ],
    'seo' => [
        'title' => 'Đăng ký tài xế Van | Nhận tư vấn',
        'description' => 'Tìm hiểu công việc, giấy tờ và các bước đăng ký tài xế Van theo khu vực.',
    ],
];
