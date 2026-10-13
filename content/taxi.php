<?php

declare(strict_types=1);

return [
    'slug' => 'taxi',
    'route' => '/taxi',
    'nav_label' => 'Taxi',
    'eyebrow' => 'Xanh SM Taxi',
    'title' => 'Vững tay lái, mở hành trình mới',
    'description' => 'Để lại thông tin để được hướng dẫn đăng ký và tìm hiểu quyền lợi dành cho tài xế Taxi.',
    'hero_image' => 'assets/images/hero-section/taxi.webp',
    'hero_alt' => 'Tài xế đứng cạnh ô tô điện Xanh SM Taxi màu cyan trong đô thị',
    'benefits_title' => 'Quyền lợi dành cho tài xế Taxi',
    'benefits' => [
        ['icon' => 'calendar', 'title' => 'Chủ động thời gian', 'description' => 'Trao đổi lịch làm việc phù hợp với nhu cầu và hình thức tham gia.'],
        ['icon' => 'chart', 'title' => 'Đối soát doanh thu', 'description' => 'Được hướng dẫn theo dõi và đối soát doanh thu trong quá trình hoạt động.'],
        ['icon' => 'document', 'title' => 'Lương cứng & bảo hiểm', 'description' => 'Hỗ trợ theo hình thức tham gia, chương trình và khu vực áp dụng.'],
        ['icon' => 'car', 'title' => 'Vận hành xe điện', 'description' => 'Không sử dụng xăng, dầu. Các khoản vận hành được trao đổi khi tư vấn.'],
        ['icon' => 'support', 'title' => 'Hướng dẫn & kỹ thuật', 'description' => 'Tìm hiểu cách sử dụng ứng dụng và hỗ trợ kỹ thuật xe điện theo chương trình.'],
        ['icon' => 'support', 'title' => 'Cộng đồng tài xế', 'description' => 'Kết nối, chia sẻ kinh nghiệm và hỗ trợ nhau trong quá trình hoạt động.'],
    ],
    'documents_title' => 'Giấy tờ đăng ký',
    'documents_intro' => 'Danh sách tham khảo để bạn chuẩn bị trước khi đến văn phòng. Giấy tờ cụ thể được hướng dẫn theo chương trình và khu vực.',
    'documents' => [
        ['title' => 'CCCD / Hộ chiếu', 'description' => ''],
        ['title' => 'Bằng lái xe (B/B2)', 'description' => 'Trao đổi cách sử dụng bằng lái trên VNeID khi tư vấn.'],
        ['title' => 'Lý lịch tư pháp số 2', 'description' => 'Có hỗ trợ tại văn phòng theo hướng dẫn đăng ký.'],
        ['title' => 'Giấy khám sức khỏe người lái xe', 'description' => ''],
    ],
    'steps' => [
        ['title' => 'Để lại thông tin', 'description' => 'Điền thông tin liên hệ và khu vực bạn muốn tham gia.'],
        ['title' => 'Nhận tư vấn', 'description' => 'Trao đổi về công việc, phương tiện và chính sách tại khu vực.'],
        ['title' => 'Chuẩn bị hồ sơ', 'description' => 'Hoàn thiện giấy tờ theo hướng dẫn dành cho bạn.'],
        ['title' => 'Bắt đầu hành trình', 'description' => 'Được hướng dẫn các bước tiếp theo và lịch tham gia theo chương trình.'],
    ],
    'stories' => require __DIR__ . '/driver-stories.php',
    'faqs' => [
        ['question' => 'Công việc tài xế Taxi là gì?', 'answer' => 'Bạn đưa đón hành khách bằng ô tô điện. Cách nhận chuyến, sử dụng xe và phục vụ hành khách sẽ được trao đổi khi tư vấn tham gia.'],
        ['question' => 'Chưa có ô tô thì bắt đầu thế nào?', 'answer' => 'Bạn có thể để lại thông tin và trao đổi nhu cầu về phương tiện. Tư vấn viên sẽ giới thiệu phương án theo chương trình và khu vực.'],
        ['question' => 'Cần bằng lái và giấy tờ gì?', 'answer' => 'Danh sách tham khảo gồm CCCD hoặc hộ chiếu, bằng lái B/B2, lý lịch tư pháp số 2 và giấy khám sức khỏe người lái xe. Tư vấn viên sẽ hướng dẫn cụ thể, gồm cách sử dụng bằng lái trên VNeID, theo chương trình và khu vực.'],
        ['question' => 'Khu vực của tôi có thể tham gia không?', 'answer' => 'Chọn khu vực bạn quan tâm trong biểu mẫu; nếu chưa thấy, chọn “Khu vực khác”. Thông tin tiếp nhận sẽ được tư vấn trực tiếp.'],
        ['question' => 'Thu nhập và các khoản chi phí ra sao?', 'answer' => 'Cách tính thu nhập, quyền lợi và các khoản liên quan được tư vấn theo chương trình và khu vực. Bạn có thể trao đổi rõ các nội dung này trước khi quyết định tham gia.'],
        ['question' => 'Sau khi đăng ký, khi nào tôi bắt đầu?', 'answer' => 'Các bước tiếp theo và lịch tham gia sẽ được hướng dẫn theo hồ sơ, chương trình và khu vực của bạn.'],
    ],
    'seo' => [
        'title' => 'Đăng ký tài xế Taxi | Nhận tư vấn',
        'description' => 'Tìm hiểu công việc, giấy tờ và các bước đăng ký tài xế Taxi theo khu vực.',
    ],
];
