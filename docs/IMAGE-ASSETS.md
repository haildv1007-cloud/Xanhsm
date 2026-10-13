# Tài sản hình ảnh

Danh mục ảnh hiện dùng trong giao diện. Nguồn và phạm vi sử dụng ghi theo từng tài sản bên dưới; không suy ra chính sách hoặc cam kết từ nội dung trong ảnh.

## `public/assets/images/logo.png`

Biểu tượng logo do người dùng cung cấp, dùng chung trong header của bốn trang.

## `public/assets/images/hero-section/bike.webp`

Ảnh hero Bike do người dùng cung cấp: hai tài xế Xanh SM Bike bên xe máy điện trong khu đô thị.

## `public/assets/images/hero-section/van.webp`

Ảnh hero Van do người dùng cung cấp: đội xe Xanh SM Van và các tài xế tại khu vực tập kết. Ảnh được dùng duy nhất cho hero trang `/van`.

## `public/assets/images/hero-section/rto.webp`

Ảnh hero RTO do người dùng cung cấp: tài xế Xanh SM đứng cạnh xe máy điện màu cyan và cầm chìa khóa, dùng riêng cho hero trang RTO.

## `public/assets/images/bike-company.webp`

Ảnh do người dùng cung cấp: tài xế ngồi trên xe máy điện, dùng cho thẻ “Chạy xe công ty”.

## `public/assets/images/bike-platform.webp`

Ảnh do người dùng cung cấp: cộng đồng tài xế và xe máy điện, dùng cho thẻ “Platform”.

## `public/assets/images/bike-rto.webp`

Ảnh do người dùng cung cấp: dãy xe máy điện tại khu vực tập kết, dùng cho thẻ “Thuê xe sở hữu”.

## `public/assets/images/hero-section/taxi.webp`

Ảnh do người dùng cung cấp trực tiếp ngày 13/10/2026: tài xế đứng cạnh ô tô điện Taxi cyan, đô thị sáng và sạch. WebP 1536×1024, 164.760 byte; giữ nguyên ảnh được cung cấp, gồm chữ/nhận diện vốn có. Không có prompt tạo mới. Đây là ảnh nội dung riêng duy nhất của trang Taxi, đặt ở hero với width/height, alt, `fetchpriority="high"` và `loading="eager"`.

## Ba ảnh chia sẻ dùng chung Bike và Taxi

- `public/assets/images/driver-thoughts/chia-se-cua-tai-xe.webp`
- `public/assets/images/driver-thoughts/chia-se-cua-tai-xe-1.webp`
- `public/assets/images/driver-thoughts/chia-se-cua-tai-xe-2.webp`

Ảnh đã có ở Bike và được người dùng yêu cầu dùng nguyên bộ cho Taxi. Mỗi ảnh 1448×1086 WebP, khai báo kích thước và lazy loading; nguồn cấu hình chung `content/driver-stories.php`. Không tạo thêm ảnh hay lời chia sẻ mới; chưa xác minh độc lập nội dung thu nhập trong ảnh. Ba ảnh Taxi tạo nhầm trong lượt đầu đã được loại khỏi workspace, không được tham chiếu hoặc xuất bản.
