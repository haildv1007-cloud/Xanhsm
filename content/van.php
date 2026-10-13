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
    'benefits_title' => 'Công việc và quyền lợi tài xế Van',
    'benefits' => [
        ['icon' => 'car', 'title' => 'Giao hàng bằng xe tải điện', 'description' => 'Lái EC Van giao hàng nội đô: hàng bán lẻ, bưu kiện, thiết bị hoặc đồ cồng kềnh vừa xe.'],
        ['icon' => 'chart', 'title' => 'Theo dõi đơn rõ ràng', 'description' => 'Trạng thái chuyến hàng và khoản đối soát được ghi nhận trên ứng dụng.'],
        ['icon' => 'support', 'title' => 'Đào tạo quy trình giao nhận', 'description' => 'Làm quen cách lấy hàng, giao hàng, xử lý đơn và phục vụ khách trước khi vận doanh.'],
        ['icon' => 'document', 'title' => 'Chính sách cho tài xế mới', 'description' => 'Tại Hà Nội và TP.HCM có chính sách thu nhập 2 tháng đầu cho tài xế mới khi đạt mức vận doanh quy định.'],
    ],
    'documents_title' => 'Giấy tờ cần chuẩn bị',
    'documents_intro' => 'Bạn có thể chuẩn bị trước những giấy tờ thường dùng khi đăng ký tài xế Van:',
    'documents' => [
        ['title' => 'CCCD / Hộ chiếu', 'description' => ''],
        ['title' => 'Bằng lái xe', 'description' => 'Trao đổi cách sử dụng bằng lái trên VNeID khi tư vấn.'],
        ['title' => 'Lý lịch tư pháp số 2', 'description' => 'Có hỗ trợ tại văn phòng theo hướng dẫn đăng ký.'],
        ['title' => 'Giấy khám sức khỏe người lái xe', 'description' => ''],
    ],
    'steps' => [
        ['title' => 'Gửi thông tin', 'description' => 'Chọn khu vực và để lại số điện thoại liên hệ.'],
        ['title' => 'Nắm công việc', 'description' => 'Tìm hiểu việc giao nhận hàng nội đô, xe EC Van và chính sách đang áp dụng.'],
        ['title' => 'Chuẩn bị và làm quen', 'description' => 'Chuẩn bị giấy tờ, học cách dùng xe, ứng dụng và quy trình giao nhận.'],
        ['title' => 'Bắt đầu nhận đơn', 'description' => 'Sau khi hoàn tất thủ tục tham gia, nhận chuyến và theo dõi đơn trên ứng dụng.'],
    ],
    'stories' => require __DIR__ . '/driver-stories.php',
    'faqs' => [
        ['question' => 'Tài xế Van làm công việc gì?', 'answer' => 'Tài xế lái xe tải điện EC Van giao nhận hàng nội đô. Công việc gồm nhận đơn, đến lấy hàng, giao đúng địa điểm và cập nhật trạng thái trên ứng dụng.'],
        ['question' => 'Công việc khác Taxi ở điểm nào?', 'answer' => 'Van chở hàng thay vì chở khách. Bạn nhận đơn giao hàng nội đô, lấy và giao hàng theo địa chỉ, cập nhật trạng thái trên ứng dụng.'],
        ['question' => 'Phương tiện được chuẩn bị như thế nào?', 'answer' => 'Dịch vụ sử dụng xe tải điện VinFast EC Van. Cách nhận và vận hành xe phụ thuộc hình thức tham gia tại khu vực của bạn.'],
        ['question' => 'Cần chuẩn bị giấy tờ gì?', 'answer' => 'Danh sách tham khảo gồm CCCD hoặc hộ chiếu, bằng lái xe, lý lịch tư pháp số 2 và giấy khám sức khỏe người lái xe.'],
        ['question' => 'Khu vực của tôi có thể tham gia không?', 'answer' => 'Dịch vụ đang hiện diện tại Hà Nội và TP.HCM. Bạn có thể chọn khu vực trong biểu mẫu; chương trình tiếp nhận tài xế tại nơi bạn chọn sẽ được xác nhận khi liên hệ.'],
        ['question' => 'Có chính sách thu nhập và sạc xe không?', 'answer' => 'Có chính sách thu nhập giai đoạn đầu cho tài xế mới ở Hà Nội và TP.HCM, cùng ưu đãi sạc xe theo hiệu suất vận doanh. Mức hưởng phụ thuộc điều kiện của từng chính sách.'],
        ['question' => 'Sau khi gửi thông tin, bước tiếp theo là gì?', 'answer' => 'Bạn nắm thông tin công việc và chính sách, chuẩn bị giấy tờ, làm quen xe và quy trình giao nhận trước khi bắt đầu nhận đơn.'],
    ],
    'seo' => [
        'title' => 'Đăng ký tài xế Van | Nhận tư vấn',
        'description' => 'Tìm hiểu công việc, giấy tờ và các bước đăng ký tài xế Van theo khu vực.',
    ],
];
