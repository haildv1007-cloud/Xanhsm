# Website đăng ký tài xế Xanh SM

Website PHP 8.2 dành cho bốn landing page: Bike, Taxi, RTO và Xanh Van. Các quyết định sản phẩm nằm trong `AGENTS.md`, `docs/UI-SPEC.md` và `docs/TECH-SPEC.md`.

## Chạy local

Yêu cầu PHP 8.2 trở lên. Sao chép `.env.example` thành `.env` nếu muốn thay cấu hình mặc định, sau đó chạy tại thư mục dự án:

```powershell
php -S 127.0.0.1:8080 -t public public/index.php
```

Mở `http://127.0.0.1:8080`. Các URL hiện có: `/`, `/taxi`, `/rto`, `/van`.

Giao diện và tương tác local của Bike, Taxi, RTO và Van đã hoàn thiện. Bốn trang dùng chung form, popup, menu, hỗ trợ và phần chia sẻ tài xế.

Backend form và hàng đợi Telegram đã được triển khai. Form chỉ hoạt động thật sau khi cấu hình MySQL/MariaDB, khóa mã hóa và chạy migration. Telegram chỉ gửi khi bot token, group chat ID và cron đã được cấu hình. SEO cơ bản, sitemap/robots, GTM cấu hình được và tối ưu tài nguyên Apache đã hoàn thiện ở local; triển khai cPanel vẫn là giai đoạn tiếp theo.

Đặt `APP_URL` bằng domain HTTPS production để canonical, Open Graph, robots và sitemap dùng URL chính xác. Đặt `GTM_ID` nếu muốn bật Google Tag Manager; để trống thì website không tải GTM.

Sau khi lưu một hồ sơ mới, website mở popup xác nhận và đặt URL `/dang-ky-thanh-cong` bằng History API để cấu hình chuyển đổi mà không chuyển trang. Đóng popup khôi phục URL nguồn. Đường dẫn thành công được đặt `noindex` và không xuất hiện trong sitemap.

## Cấu hình database và Telegram

Sao chép `.env.example` thành `.env`, điền cấu hình database và tạo khóa mã hóa 32 byte dạng base64:

```powershell
php -r "echo base64_encode(random_bytes(32)), PHP_EOL;"
php scripts/migrate.php
```

Bot Telegram phải được thêm vào group đích và có quyền gửi tin nhắn. Điền `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID` của group (thường là số âm), một `CRON_SECRET` dài/ngẫu nhiên và đặt `TELEGRAM_ENABLED=true`. Có thể chạy thử hàng đợi bằng PHP CLI:

```powershell
php cron/send-telegram.php
```

Với dịch vụ cron nhận URL, dùng:

```text
https://your-domain.example/cron/send-telegram?token=YOUR_CRON_SECRET
```

Thay domain và secret bằng cấu hình thật. URL cron là bí mật vì token có thể xuất hiện trong lịch sử hoặc log của dịch vụ cron; không chia sẻ URL và đổi `CRON_SECRET` nếu bị lộ. Endpoint vẫn hỗ trợ header `X-Cron-Secret` khi hệ thống cron cho phép. Chạy mỗi phút hoặc theo chu kỳ tối thiểu hosting hỗ trợ. Không đặt bot token, group ID, cron secret hoặc khóa mã hóa trong Git.

Sau khi khởi động server, chạy kiểm tra route/anchor/component và cú pháp JavaScript:

```powershell
php scripts/check-pages.php
php scripts/test-lead-service.php
node --check public/assets/js/app.js
```

Chi tiết nghiệm thu và phần còn lại nằm trong mục 11 của `docs/TECH-SPEC.md`. Ảnh kiểm tra Taxi ở `output/taxi-qa/`.

## Đóng gói production

Chạy lệnh sau để tạo file ZIP chỉ gồm mã runtime, migration, file cấu hình mẫu và hướng dẫn vận hành:

```powershell
powershell -ExecutionPolicy Bypass -File scripts/build-release.ps1 -Version production
```

File được tạo trong `dist/`. Gói phát hành không chứa `.env`, log, database thử nghiệm, ảnh concept trong `output/`, tài liệu nội bộ hoặc bộ kiểm tra local. Sau khi giải nén, tạo `.env` từ `.env.example`, đặt document root của domain vào thư mục `public/`, chạy `php scripts/migrate.php` và cấu hình cron Telegram.
