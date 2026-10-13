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
        ['icon' => 'car', 'title' => 'Lái ô tô điện', 'description' => 'Với hình thức tài xế công ty, xe điện được bố trí để vận doanh; bạn không cần mua ô tô để bắt đầu.'],
        ['icon' => 'chart', 'title' => 'Thu nhập theo chuyến và thưởng', 'description' => 'Hình thức tài xế công ty có lương cứng, chia sẻ doanh số và thưởng theo chính sách đang áp dụng.'],
        ['icon' => 'document', 'title' => 'Hợp đồng và bảo hiểm', 'description' => 'Tài xế công ty ký hợp đồng lao động, tham gia BHXH, BHYT và BHTN theo chế độ áp dụng.'],
        ['icon' => 'calendar', 'title' => 'Có chính sách sạc xe', 'description' => 'Xe điện có chính sách hỗ trợ chi phí sạc và bảo dưỡng; mức hỗ trợ phụ thuộc chương trình hiện hành.'],
        ['icon' => 'support', 'title' => 'Làm quen xe và ứng dụng', 'description' => 'Trước khi nhận chuyến, tài xế được đào tạo cách dùng xe điện, ứng dụng và quy cách phục vụ.'],
        ['icon' => 'chart', 'title' => 'Theo dõi kết quả chạy xe', 'description' => 'Chuyến xe và doanh số được ghi nhận để tài xế theo dõi, đối soát trong quá trình làm việc.'],
    ],
    'documents_title' => 'Giấy tờ đăng ký',
    'documents_intro' => 'Bạn có thể chuẩn bị trước những giấy tờ thường dùng khi đăng ký tài xế Taxi:',
    'documents' => [
        ['title' => 'CCCD / Hộ chiếu', 'description' => 'Có thể sử dụng CCCD hoặc BLX trên VNeID.'],
        ['title' => 'Bằng lái xe (B/B2)', 'description' => 'Có thể sử dụng CCCD hoặc BLX trên VNeID.'],
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
        ['question' => 'Công việc tài xế Taxi là gì?', 'answer' => 'Bạn lái ô tô điện đưa đón hành khách, nhận chuyến qua ứng dụng và theo dõi kết quả chạy xe để đối soát doanh số.'],
        ['question' => 'Chưa có ô tô thì bắt đầu thế nào?', 'answer' => 'Bạn có thể chọn hình thức tài xế công ty: xe điện được bố trí để vận doanh, không cần mua ô tô ngay từ đầu.'],
        ['question' => 'Cần bằng lái và giấy tờ gì?', 'answer' => 'Danh sách tham khảo gồm CCCD hoặc hộ chiếu, bằng lái B/B2, lý lịch tư pháp số 2 và giấy khám sức khỏe người lái xe. Tư vấn viên sẽ hướng dẫn cụ thể, gồm cách sử dụng bằng lái trên VNeID, theo chương trình và khu vực.'],
        ['question' => 'Khu vực của tôi có thể tham gia không?', 'answer' => 'Chọn tỉnh/thành trong biểu mẫu. Khu vực và chương trình đang tiếp nhận sẽ được xác nhận khi liên hệ với bạn.'],
        ['question' => 'Thu nhập và các khoản chi phí ra sao?', 'answer' => 'Với hình thức tài xế công ty, thu nhập gồm lương cứng, phần chia sẻ doanh số và thưởng theo chính sách áp dụng. Xe điện có chính sách sạc và bảo dưỡng riêng; mức cụ thể phụ thuộc khu vực và thời điểm.'],
        ['question' => 'Sau khi đăng ký, khi nào tôi bắt đầu?', 'answer' => 'Bạn bắt đầu nhận chuyến sau khi hoàn tất thủ tục tham gia và làm quen xe, ứng dụng. Lịch cụ thể phụ thuộc phương án và khu vực bạn chọn.'],
    ],
    'seo' => [
        'title' => 'Đăng ký tài xế Taxi | Nhận tư vấn',
        'description' => 'Tìm hiểu công việc, giấy tờ và các bước đăng ký tài xế Taxi theo khu vực.',
    ],
];
