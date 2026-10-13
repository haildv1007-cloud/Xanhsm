# Hướng dẫn cho AI làm việc trong repository

## Đọc trước khi code

1. Đọc `AGENTS.md` (file này).
2. Đọc `docs/UI-SPEC.md`: yêu cầu giao diện, nội dung và tương tác đã chốt.
3. Đọc `docs/FRONTEND-GUIDE.md`: quy chuẩn trình bày, màu sắc, typography và component.
4. Đọc `docs/TECH-SPEC.md`: công nghệ, dữ liệu, cấu hình và triển khai.

Bốn file này là bộ tài liệu chính cho AI. Khi người dùng sửa yêu cầu, cập nhật phần liên quan để lần code sau không dùng quyết định cũ. Yêu cầu trực tiếp mới nhất của người dùng được ưu tiên hơn tài liệu.

Lộ trình triển khai và bảng tiến độ nằm ở mục 11 của `docs/TECH-SPEC.md`. Khi được yêu cầu code, xác định giai đoạn cần làm theo yêu cầu người dùng và hiện trạng repository; cập nhật trạng thái cùng bằng chứng kiểm tra sau mỗi giai đoạn. Lộ trình không có nghĩa là các chức năng đã được triển khai.

## Mục tiêu và phạm vi

- Website đăng ký tài xế Xanh SM của đơn vị liên kết tuyển dụng, ưu tiên mobile và tốc độ tải landing page.
- Bốn trang: Bike tại `/`, Taxi tại `/taxi`, RTO tại `/rto`, Van tại `/van`.
- PHP 8.2 + MySQL/MariaDB; HTML xuất từ PHP; CSS và JavaScript thuần.
- Một hệ thống form dùng chung, lưu database và gửi thông báo Telegram bằng cron.
- Hosting cPanel có domain và Git Version Control. Có SEO cơ bản và Google Tag Manager.
- Giai đoạn hiện tại mới có ảnh concept trong `output/`; ảnh không chứng minh chức năng đã được triển khai.

## Quy tắc thực hiện

- Ưu tiên cấu trúc đơn giản, thành phần dùng lại và thư viện nhỏ khi cần. Không tự bổ sung SPA, CMS, framework lớn, Redis hoặc dịch vụ nền thường trực.
- Không tự tạo thêm trang chủ riêng: Bike là trang chủ theo phương án hiện tại.
- Không tự mở rộng sang CRM hoặc trang quản trị; trang quản trị vẫn là đề xuất chưa được xác nhận riêng.
- Giữ nguyên thứ tự section, form và vị trí điểm nhấn trong `docs/UI-SPEC.md`; mọi quyết định trình bày phải theo `docs/FRONTEND-GUIDE.md`.
- Không gọi website là trang chính thức. Không tự chèn thông báo “không phải trang chính thức” hoặc lặp lại thông tin đơn vị liên kết ở nhiều chỗ.
- Không bịa chính sách, số thu nhập, lời chứng thực, số điện thoại, địa chỉ hoặc hạn khuyến mại. Nội dung chưa có nguồn dùng bản nháp trung tính, ghi rõ mục cần bổ sung trong báo cáo triển khai.
- Không dùng thông tin cá nhân trong ảnh người dùng gửi làm dữ liệu thử nghiệm hoặc nội dung xuất bản.
- Không đưa khóa, mật khẩu, `.env`, dữ liệu hồ sơ, log hay bản sao database vào Git hoặc tài nguyên công khai.
- Thực hiện các lựa chọn kỹ thuật thông thường trong phạm vi yêu cầu; không dừng để xin xác nhận từng chi tiết nhỏ. Điểm chưa chốt được ghi ở cuối tài liệu kỹ thuật.
- Khi bàn giao: nêu phần đã làm, kiểm tra đã chạy, hạn chế còn lại. Không báo đã kiểm thử hoặc đã triển khai nếu chưa thực hiện.

## Kiểm tra theo phạm vi thay đổi

- Giao diện: kiểm tra mobile hẹp và desktop, không tràn ngang, không bị menu/bong bóng che nội dung; popup thao tác được bằng bàn phím.
- Form/backend: kiểm tra dữ liệu hợp lệ, lỗi xác thực, bấm gửi lặp, lỗi database và lỗi Telegram; lỗi Telegram không làm mất hồ sơ.
- Cron: kiểm tra thử lại có giới hạn, không chạy chồng, không gửi lại các job đã hoàn tất.
- Tracking: chỉ ghi chuyển đổi sau khi lưu thành công, không truyền dữ liệu định danh cá nhân.
- Triển khai: không công khai `.env`, log, cron, database hoặc mã nội bộ; giữ cấu hình và dữ liệu khi cập nhật code.
- Chạy kiểm tra phù hợp thay đổi; không thêm bộ công cụ hoặc bài test hình thức cho thay đổi nội dung nhỏ.

## Tham chiếu thiết kế

- `output/mobile-demo-v5/01-bike-mobile.png`
- `output/mobile-demo-v5/02-taxi-mobile.png`
- `output/mobile-demo-v5/03-rto-mobile.png`
- `output/mobile-demo-v5/04-van-mobile.png`

Ảnh là tham chiếu thị giác. Đặc tả bằng chữ trong `docs/UI-SPEC.md` được ưu tiên khi ảnh khác yêu cầu. Các bản v3/v4 và tài liệu cũ trong `output/` chỉ là lịch sử, không phải yêu cầu bổ sung.
