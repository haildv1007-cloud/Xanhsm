# Kiến trúc kỹ thuật và vận hành

Trạng thái: phương án triển khai đơn giản đã trao đổi. Chưa có thông tin truy cập hosting, database hoặc Telegram; không điền giả các giá trị này.

## 1. Công nghệ

- PHP 8.2; web và PHP CLI chạy cron phải dùng cùng phiên bản tương thích.
- MySQL/MariaDB, PDO với prepared statements, bảng InnoDB hỗ trợ transaction, charset `utf8mb4`.
- PHP xuất HTML sẵn; CSS và JavaScript thuần, dùng chung thành phần.
- Thư viện nhỏ qua Composer nếu cần (ví dụ đọc `.env`); khóa phiên bản bằng lockfile. Nếu hosting không có Composer, chuẩn bị dependency ở môi trường build tương thích.
- Không cần Node chạy trên hosting, SPA, Redis hay queue worker thường trực.
- Worker Telegram có thể gọi bằng PHP CLI hoặc endpoint HTTP được bảo vệ bằng `CRON_SECRET`; HTTP chấp nhận header `X-Cron-Secret` hoặc query `token` cho dịch vụ cron chỉ nhận URL. Worker gọi Telegram Bot API qua HTTPS. Kiểm tra hosting có PDO MySQL, cURL, mbstring và OpenSSL.

## 2. Cấu trúc mục tiêu

```text
project/
├── AGENTS.md
├── docs/
│   ├── UI-SPEC.md
│   ├── FRONTEND-GUIDE.md
│   └── TECH-SPEC.md
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── robots.txt
│   ├── sitemap.xml
│   └── assets/{css,js,images,fonts}/
├── app/
│   ├── bootstrap.php
│   ├── routes.php
│   ├── controllers/
│   ├── services/
│   └── views/{layouts,pages,components}/
├── config/
│   ├── site.php
│   └── forms.php
├── content/{bike,taxi,rto,van}.php
├── cron/send-telegram.php
├── database/migrations/
├── storage/logs/
├── .env
├── .env.example
├── .gitignore
└── .cpanel.yml
```

Đây là cấu trúc đề xuất, không phải danh sách file đã tồn tại. Chỉ `public/` được truy cập qua web. Nếu domain chính dùng `public_html` cố định, triển khai nội dung `public/` vào đó và đặt app/config/storage/cron bên ngoài; chỉnh đường dẫn bootstrap tương ứng. Repository Git không đặt công khai.

## 3. Cấu hình

`.env` chứa giá trị theo môi trường và bí mật:

```dotenv
APP_ENV=production
APP_URL=
APP_TIMEZONE=Asia/Ho_Chi_Minh
APP_ENCRYPTION_KEY=
DB_HOST=localhost
DB_PORT=3306
DB_NAME=
DB_USER=
DB_PASS=
TELEGRAM_ENABLED=true
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHAT_ID=
GTM_ID=
```

- `.env.example` chỉ có tên biến/giá trị mẫu không nhạy cảm. `.env` thật không vào Git và không bị ghi đè khi deploy.
- `config/site.php`: hotline, Zalo URL, bật/tắt support bubble, countdown, thời lượng, thiết lập giao diện chung.
- `config/forms.php`: nhãn trường, required/optional, danh sách khu vực, phương tiện, loại hình và tổ hợp hợp lệ.
- `content/*.php`: tiêu đề, hero, lợi ích, giấy tờ, quy trình, chia sẻ, FAQ và SEO từng trang; nội dung dài không nhét vào `.env`.
- Bí mật không được xuất vào HTML, JavaScript, thông báo lỗi hoặc log. Thiếu cấu hình thiết yếu phải báo lỗi vận hành an toàn, không giả thành công.

## 4. Đường dẫn và form

- GET `/`, `/taxi`, `/rto`, `/van`: bốn landing page.
- POST `/api/leads`: một endpoint chung nhận đăng ký, trả lỗi xác thực hoặc kết quả đã lưu.
- Có trang chính sách bảo mật hỗ trợ form; không tính là một landing page mới.
- Trang không tồn tại trả HTTP 404; không biến mọi URL sai thành trang Bike.
- Một component form cho inline/modal; tránh trùng HTML ID khi xuất nhiều instance.
- Mỗi lần gửi logic có submission token dùng chống lặp. Retry cùng token trả về kết quả cũ, không tạo hồ sơ/job mới.
- Kiểm tra ở cả client và server; server là nguồn quyết định. Giới hạn độ dài, chuẩn hóa điện thoại, kiểm tra lựa chọn theo allowlist, CSRF, honeypot và rate limit phù hợp shared hosting.
- Dùng PDO prepared statements, escape dữ liệu khi xuất HTML, xử lý an toàn nội dung gửi Telegram.
- Không khóa vĩnh viễn theo số điện thoại: một người có thể có nhu cầu đăng ký lại; chống lặp kỹ thuật khác với quy tắc gộp hồ sơ nghiệp vụ.

## 5. Database tối thiểu

### `leads`

- ID nội bộ, mã hồ sơ công khai không chứa PII, submission token duy nhất.
- Họ tên, số điện thoại, Zalo, CCCD đã mã hóa.
- Khu vực, phương tiện, loại hình: dùng mã ổn định; nhãn hiển thị tiếng Việt nằm trong cấu hình.
- Trang nguồn, vị trí form (`inline`/`modal`).
- UTM source/medium/campaign/content/term; click ID như gclid/fbclid nếu có, giới hạn độ dài và chỉ nhận trường cho phép.
- Trạng thái xử lý (`new`, `contacted`, `pending_documents`, `completed`) và timestamps.
- Điện thoại, Zalo, CCCD là chuỗi, không phải kiểu số. Mã hóa CCCD bằng thư viện chuẩn có xác thực; khóa riêng ngoài database, không tự thiết kế thuật toán.

### `telegram_jobs`

- ID, lead ID, loại thông báo; unique constraint cho cặp lead/loại thông báo.
- Trạng thái (`pending`, `processing`, `retry`, `sent`, `failed`).
- Số lần thử, thời điểm thử tiếp, thời điểm bắt đầu xử lý, gửi thành công và lỗi gần nhất đã loại bí mật.
- Telegram message ID khi có.
- Job tham chiếu lead; tránh sao chép toàn bộ dữ liệu cá nhân sang payload/log.

Tạo lead và job trong **cùng một transaction**. Chỉ phản hồi thành công sau khi commit. Database là nơi lưu dữ liệu chính; Telegram là kênh thông báo.

## 6. Cron Telegram

Luồng: form → xác thực → transaction tạo lead/job → báo thành công; cron riêng đọc job → gọi Telegram → cập nhật kết quả.

- Đề xuất chạy mỗi phút nếu hosting cho phép; dùng đường dẫn tuyệt đối đến PHP CLI và script.
- Cron có khóa chống chạy chồng, xử lý batch giới hạn và thời gian chạy giới hạn. Script không mở thành endpoint web công khai.
- Có thời hạn khóa/trạng thái processing để phục hồi nếu tiến trình chết giữa chừng.
- Chỉ đánh dấu `sent` khi Bot API trả kết quả thành công; lưu message ID.
- Lỗi tạm thời dùng backoff, tôn trọng `retry_after` khi Telegram giới hạn tần suất; giới hạn số lần thử, quá giới hạn chuyển `failed` để kiểm tra/gửi lại có chủ đích.
- Bot token sai/quyền chat sai phải được phân biệt với lỗi mạng; không retry dồn dập vô hạn.
- Không gửi lại job đã `sent`. Bot API không bảo đảm exactly-once khi mất phản hồi; tin nên có mã hồ sơ để đối chiếu trường hợp trùng hiếm gặp.
- Telegram gửi theo mẫu người dùng chốt: tiêu đề, tên, điện thoại, khu vực, Zalo, tình trạng có xe/loại hình, phương tiện, CCCD và URL nguồn. CCCD được giải mã để gửi vào group đã cấu hình; bot/group phải giới hạn người được phép truy cập hồ sơ.
- Không log URL chứa bot token hoặc toàn bộ hồ sơ. Telegram lỗi không đổi hồ sơ đã lưu thành đăng ký thất bại.

## 7. SEO, hiệu năng và tracking

- Mỗi trang có title, description, canonical, Open Graph và H1 phù hợp; nội dung HTML sẵn từ server.
- Sitemap chỉ chứa URL công khai hợp lệ; robots theo môi trường. Trang cảm ơn nếu có thì noindex; robots không thay thế kiểm soát truy cập.
- Không tự khai schema JobPosting, review/rating hoặc thông tin doanh nghiệp khi chưa có dữ liệu phù hợp.
- Ảnh WebP/AVIF với fallback khi cần, đúng kích thước và có width/height; hero ưu tiên tải, ảnh dưới màn hình lazy-load.
- Font hỗ trợ tiếng Việt, ít weight; icon SVG; JavaScript tải defer, carousel dùng cuộn ngang đơn giản.
- Cache asset có phiên bản; nén nội dung/OPcache theo hosting. Không cache phản hồi form hoặc dữ liệu cá nhân.
- GTM ID đọc từ config, gắn đúng một lần trong layout chung; không gắn thêm cùng tag qua nhiều cách gây đếm trùng.
- `dataLayer` thống nhất: `form_open`, `form_start`, `generate_lead`, `click_call`, `click_zalo`, `view_bike_details`.
- `generate_lead` chỉ phát sau phản hồi xác nhận đã commit lead mới. Bấm lặp hoặc nhận lại kết quả cùng submission token không phát lại chuyển đổi.
- Sau lead mới, popup xác nhận mở trên trang hiện tại và `history.pushState` đặt URL `/dang-ky-thanh-cong`; không tải lại trang. Đường dẫn này trả 200 khi mở trực tiếp, dùng canonical trang Bike và `noindex,follow`; đóng popup khôi phục URL nguồn.
- Chỉ gửi metadata cần thiết như trang/loại hình/vị trí form. Không đưa tên, điện thoại, Zalo, CCCD vào analytics, URL, UTM hoặc dataLayer.
- Giữ nguồn quảng cáo qua thao tác chuyển giữa các trang bằng cơ chế phù hợp; không lưu dữ liệu nhạy cảm cùng dữ liệu attribution. Chính sách lưu trữ/đồng ý phải khớp triển khai thực tế.

## 8. cPanel, Git và vận hành

- Xác minh document root, bản PHP web/CLI, database, extension, outbound HTTPS và chu kỳ cron tối thiểu trước triển khai.
- `.cpanel.yml` mô tả tác vụ deploy; chỉ triển khai file runtime cần thiết, không đẩy ảnh concept/docs/bí mật vào webroot.
- Nếu dùng GitHub làm remote: Update from Remote rồi Deploy HEAD Commit trong cPanel. GitHub push không mặc nhiên tự deploy.
- Push trực tiếp vào repository do cPanel quản lý có thể auto-deploy khi đã cấu hình phù hợp; chọn quy trình theo khả năng hosting.
- Giữ `.env`, storage và dữ liệu khi cập nhật. Migration có phiên bản; không chạy lệnh xóa/khởi tạo lại bảng trên production.
- Có backup database định kỳ, lưu ngoài webroot, giới hạn truy cập; kiểm tra khả năng khôi phục. Git không phải backup hồ sơ.
- HTTPS; tắt hiển thị stack trace ở production; log kỹ thuật đã loại bí mật, có giới hạn dung lượng/thời gian lưu.
- Khi thay đổi schema, kế hoạch khôi phục code phải xét tương thích dữ liệu; không tự động rollback dữ liệu đã nhận.

## 9. Điểm chưa chốt và dữ liệu cần bổ sung

Không cản trở dựng layout/component bằng cấu hình và dữ liệu mẫu rõ ràng, nhưng không tự biến đề xuất thành quyết định nghiệp vụ:

- Trang quản trị: mới được đề xuất; chưa xác nhận làm. Phạm vi hiện tại là landing page, lưu DB và Telegram.
- Countdown: mốc bắt đầu, tính theo chiến dịch hay phiên người dùng, và hành vi hết giờ chưa chốt. Có thể dựng component tám tiếng; chưa xuất bản thông điệp tạo hạn ưu đãi không có thật.
- Required/optional đã chốt: họ tên, số điện thoại, tỉnh/thành, phương tiện và loại hình bắt buộc; Zalo và CCCD không bắt buộc, không ghi chú “không bắt buộc” trên giao diện.
- Danh sách tỉnh/thành đã được cấu hình theo danh sách người dùng cung cấp. Tổ hợp tỉnh/thành, phương tiện và loại hình được tiếp nhận, cùng phương tiện cụ thể của RTO, vẫn cần xác nhận trước vận hành thật.
- Nội dung chính sách/thu nhập/giấy tờ được duyệt, hình ảnh/lời chia sẻ được phép sử dụng, thông tin liên hệ và nội dung bảo mật.
- Domain chính xác, cPanel/PHP/cron, DB, bot token/chat ID và GTM ID sẽ cung cấp qua cấu hình an toàn.
- Thời hạn lưu hồ sơ/backup và người được truy cập dữ liệu cần xác định khi vận hành.

## 10. Nguồn kỹ thuật tham khảo

- PHP: https://www.php.net/supported-versions.php
- cPanel cron: https://docs.cpanel.net/cpanel/advanced/cron-jobs/
- cPanel Git deployment: https://docs.cpanel.net/knowledge-base/web-services/guide-to-git-set-up-deployment/
- Telegram Bot API: https://core.telegram.org/bots/api
- Google dataLayer: https://developers.google.com/tag-platform/tag-manager/datalayer
- Google Analytics và dữ liệu định danh: https://support.google.com/analytics/answer/6366371?hl=en

Kiểm tra lại tài liệu nhà cung cấp khi thực sự triển khai nếu hành vi hoặc phiên bản liên quan đã thay đổi.

## 11. Lộ trình triển khai

Ngày lập: 2026-10-13. Lộ trình gồm bảy giai đoạn; các giai đoạn 1–6 đã hoàn tất ở môi trường local, chưa triển khai lên hosting.

### Bảng tiến độ

| Giai đoạn | Đầu ra chính | Trạng thái | Bằng chứng / việc còn lại |
| --- | --- | --- | --- |
| 1. Nền tảng | Khung PHP, cấu hình, routing và layout chung | Hoàn tất local | 14 file PHP lint thành công; `/`, `/taxi`, `/rto`, `/van` trả 200, URL sai trả 404; preview local đã mở. Máy kiểm tra có PHP 8.4.24, mã chỉ dùng cú pháp tương thích PHP 8.2; chưa xác minh hosting/PHP 8.2 thật. |
| 2. Bike và component | Trang Bike hoàn chỉnh giao diện, popup và form dùng chung | Hoàn tất local | Đủ hero → countdown → form → lợi ích → 3 hình thức → giấy tờ → quy trình → chia sẻ → FAQ → footer; popup loại hình chuyển sang form có giá trị chọn sẵn; Be Vietnam Pro được self-host; kiểm tra 360/390/desktop không tràn ngang; không có lỗi console. Form đã được nối backend ở giai đoạn 4; Gọi/Zalo vẫn cần thông tin liên hệ production. |
| 3. Ba trang còn lại | Taxi, RTO, Van dùng chung hệ thống | Hoàn tất giao diện local | Người dùng xác nhận giao diện bốn trang đã hoàn tất. Các trang dùng chung form, popup, menu, hỗ trợ và ba ảnh chia sẻ; nội dung/chính sách thật vẫn có thể cập nhật bằng cấu hình/content trước production. |
| 4. Form và database | Gửi đăng ký, lưu lead/job, chống lặp và chống spam | Đã triển khai, chờ MySQL thật | Có migration MySQL, endpoint `/api/leads`, validate server, CSRF, honeypot, rate limit, submission token, mã hóa CCCD và transaction lead/job. Kiểm thử SQLite cho lưu, mã hóa và chống lặp đạt; cần chạy migration và kiểm thử lỗi DB trên MySQL/MariaDB thật. |
| 5. Telegram cron | Thông báo, retry, khóa chống chạy chồng | Đã triển khai, chờ bot/group thật | Worker dùng Telegram Bot API gửi mẫu hồ sơ đã chốt vào `TELEGRAM_CHAT_ID`; chạy bằng PHP CLI hoặc URL `/cron/send-telegram?token=...` cho dịch vụ cron chỉ nhận URL. Có named lock, phục hồi job dở, retry/backoff và failed. Chưa gửi thật vì chưa có bot token/group ID. |
| 6. SEO, tracking, hiệu năng | Metadata, attribution, GTM và tối ưu mobile | Hoàn tất code local, chờ GTM ID/domain thật | Bốn trang có metadata ngắn, canonical/OG khi có `APP_URL`, robots/sitemap động và favicon. GTM chỉ tải với ID hợp lệ; event không chứa PII, `generate_lead` chỉ phát cho lead mới. Đã thêm preload hero, lazy/decode ảnh dưới fold và cache/nén Apache. Chưa kiểm chứng container GTM hoặc hiệu năng production vì thiếu ID/domain/hosting. |
| 7. cPanel và bàn giao | Website chạy trên domain, cron/backup và hướng dẫn vận hành | Đã đóng gói local, chờ hosting | Có script tạo ZIP production chỉ gồm runtime/migration/cấu hình mẫu; cần GitHub remote, thông tin hosting và cấu hình thật để push/deploy/nghiệm thu. |

Chỉ đổi thành “Hoàn tất” khi đáp ứng đầu ra và điều kiện nghiệm thu của giai đoạn. Nếu mới kiểm tra bằng mock/local, ghi rõ; không coi đó là bằng chứng đã chạy trên hosting thật. Không cần dừng xin duyệt sau từng giai đoạn trừ khi người dùng yêu cầu hoặc có quyết định thực sự chưa đủ thông tin.

### Giai đoạn 1 — Dựng nền tảng

- Kiểm tra file hiện có và runtime PHP; xác định phần nào kiểm tra được tại local. Thiếu thông tin hosting không ngăn dựng khung local.
- Tạo cấu trúc mục 2, bootstrap, cấu hình môi trường, `.env.example`, `.gitignore` và cách chạy local.
- Tạo routing bốn trang, 404, layout/header/footer dùng chung, design tokens màu/chữ/khoảng cách.
- Chuẩn bị cấu trúc content và form config để không hard-code bốn bản độc lập.
- Nghiệm thu: bốn URL tải được bằng PHP, URL sai trả 404, cấu hình bí mật không nằm trong public, không cần database để xem landing page.

### Giai đoạn 2 — Hoàn thiện Bike làm mẫu

- Dựng đủ thứ tự section theo UI-SPEC, ưu tiên mobile trước rồi mở rộng desktop.
- Hoàn thiện các component: form inline/modal, menu dưới, hỗ trợ Gọi/Zalo, FAQ, chia sẻ tài xế và countdown tám tiếng.
- Dựng ba thẻ Bike cùng popup chi tiết vàng–xanh; chuyển sang form có lựa chọn sẵn và giữ dữ liệu đang nhập trong bộ nhớ trang.
- Form ở giai đoạn này chỉ là giao diện; chưa được báo “đã đăng ký thành công” khi chưa có backend lưu thật.
- Nghiệm thu: kiểm tra 360px, 390px và desktop; không tràn ngang hoặc che nội dung; popup giữa màn hình, không chồng modal, bàn phím/focus hoạt động.
- Mốc xem trước: có trang Bike tương tác được để người dùng xem bố cục thật. Countdown chỉ ở chế độ demo nếu quy tắc vận hành chưa được chốt.

### Giai đoạn 3 — Hoàn thiện Taxi, RTO và Van

- Tái sử dụng component đã làm; tách nội dung và hình ảnh theo trang.
- Cấu hình phương tiện/loại hình chọn sẵn theo ánh xạ đã biết; không tự giả định các tổ hợp được tuyển.
- Giữ nổi bật lợi ích trên cả bốn trang; chỉ Bike có ba thẻ và popup chi tiết đặc thù.
- Nghiệm thu: đủ bốn trang, menu/CTA đúng đích, footer đúng nguyên văn, form thống nhất; liệt kê nội dung/ảnh còn thiếu bằng ghi chú bàn giao.
- Mốc xem trước: hoàn chỉnh giao diện toàn website; chưa yêu cầu có Telegram hoặc hosting production.

### Giai đoạn 4 — Kết nối form và database

- Tạo migration `leads` và `telegram_jobs`, kết nối PDO và endpoint POST `/api/leads`.
- Nối cả form inline/modal vào endpoint; kiểm tra dữ liệu, CSRF, rate limit, honeypot, mã hóa CCCD và submission token.
- Lưu lead/job trong cùng transaction, trả lỗi rõ và không mất dữ liệu nhập khi lỗi.
- Lưu metadata nguồn theo các trường cho phép; chuẩn bị luồng attribution để hoàn thiện ở giai đoạn 6.
- Nghiệm thu bằng database thử nghiệm: gửi hợp lệ tạo một lead và một job; gửi lại cùng token không tạo thêm; input sai bị từ chối; lỗi database không báo thành công và không để lại dữ liệu nửa chừng.
- Quy tắc required/optional và danh sách tuyển dụng có thể cấu hình cho bản thử; phải chốt trước khi nhận hồ sơ thật.

### Giai đoạn 5 — Gửi Telegram bằng cron

- Viết service Bot API và worker đọc job; hỗ trợ PHP CLI hoặc HTTP curl có secret. Nội dung thông báo theo mẫu đã chốt và chỉ gửi vào group được cấu hình.
- Thêm khóa chống chạy chồng, phục hồi job bị bỏ dở, timeout, retry có backoff và trạng thái failed.
- Kiểm tra tự động bằng mô phỏng lỗi mạng/API; sau đó kiểm tra một thông báo thật với bot/chat thử nghiệm khi được cung cấp.
- Nghiệm thu: job thành công chuyển sent, chạy lại không gửi lại job đó; lỗi có lịch thử lại; tiến trình chồng bị chặn; hồ sơ vẫn còn khi Telegram lỗi.
- Ghi rõ cron mới được kiểm tra local hay đã chạy theo lịch trên hosting. Lệnh cron production hoàn thiện ở giai đoạn 7.

### Giai đoạn 6 — SEO, quảng cáo và tối ưu tốc độ

- Hoàn thiện title/description/canonical/OG từng trang, sitemap, robots và trang bảo mật.
- Hoàn thiện lưu nguồn UTM/click ID khi chuyển trang và gửi form; không lưu PII vào URL hoặc analytics.
- Tích hợp GTM cấu hình được và các event thống nhất; đo lead sau khi server xác nhận lưu, chống đếm lại cùng submission.
- Tối ưu ảnh, font, CSS/JS, ưu tiên hero, lazy-load phần dưới; kiểm tra khả năng truy cập của form/modal.
- Nghiệm thu: rà metadata cả bốn trang; kiểm tra event và nguồn quảng cáo bằng hồ sơ thử; đo hiệu năng mobile, ghi điều kiện đo/kết quả và sửa vấn đề chính. Không cam kết điểm Lighthouse cố định khi chưa đo trên hosting.
- Nếu chưa có GTM container, chỉ xác nhận event trong dataLayer; ghi tích hợp Google Ads/GA4 thật còn chờ cấu hình container và kiểm tra.

### Giai đoạn 7 — Triển khai cPanel và bàn giao

- Xác minh điều kiện hosting ở mục 8; chuẩn bị `.cpanel.yml`, vị trí public/private, `.env` production và migration.
- Kiểm tra trên môi trường thử được bảo vệ nếu có; không đưa hồ sơ thử thành chuyển đổi quảng cáo thật.
- Cấu hình domain/HTTPS, cron theo khả năng hosting, quyền file, cache và backup database.
- Thay nội dung mẫu bằng nội dung được cung cấp; xử lý các điểm còn mở ảnh hưởng việc nhận đăng ký thật ở mục 9. Nếu thiếu một đầu vào, hoàn tất phần độc lập và báo đúng phần còn chờ.
- Nghiệm thu trên hosting: mở bốn trang, gửi hồ sơ thử có kiểm soát, đối chiếu database → Telegram → tracking, thử cập nhật code không mất `.env`/dữ liệu và kiểm tra không truy cập được file nội bộ.
- Xác nhận backup có thể khôi phục trong môi trường thử; ghi cách kiểm tra job failed, log, thay nội dung và phục hồi code.
- Bổ sung hướng dẫn vận hành cụ thể vào tài liệu này để giữ bộ tài liệu chính trong ba file; không ghi bí mật thật vào hướng dẫn.

### Cách tiếp tục cho AI ở lần code sau

1. Đọc bốn tài liệu chính và kiểm tra hiện trạng code, không dựa riêng vào bảng trạng thái.
2. Làm giai đoạn được người dùng yêu cầu; nếu được giao triển khai toàn bộ thì tiếp tục các giai đoạn theo thứ tự trong phạm vi đã được cho phép.
3. Sau mỗi giai đoạn, cập nhật hàng tiến độ tương ứng với file/chức năng đã làm, kiểm tra đã chạy và phần còn chờ.
4. Mốc tiếp theo: đóng gói và triển khai **Giai đoạn 7** khi người dùng ra lệnh; cần cấu hình hosting, database, bot/group Telegram, domain và GTM thật. Cả bốn trang cùng backend hiện đã hoàn tất và được kiểm tra ở local.

### Bằng chứng nghiệm thu Taxi local — 13/10/2026

- Tách từ Bike các component `inline-registration`, `benefits`, `documents`, `process`, `stories`, `faq`, `registration-modal`, `story-modal`, `content-icon`; giữ nội dung và thứ tự Bike hiện có. Layout nạp form modal, menu, hỗ trợ cho cả bốn landing page. Taxi dùng view `app/views/pages/taxi.php`, nội dung tại `content/taxi.php`; ba ảnh chia sẻ lấy chung `content/driver-stories.php`.
- Form mặc định đọc `config/forms.php:page_defaults`. Chỉ Bike có ánh xạ hiện có `electric-bike`; không suy đoán lựa chọn Taxi/RTO/Van. Danh sách khu vực vẫn là cấu hình giao diện, không xác nhận là khu vực đang tuyển.
- Đồng bộ cả hai chiều các trường và checkbox Zalo; khi chọn cùng số điện thoại, Zalo cập nhật theo điện thoại và readonly. Chỉ giữ thông tin trong DOM/bộ nhớ trang. Gửi lặp vẫn chỉ báo xem trước, chưa có yêu cầu lưu backend.
- Countdown demo dùng sessionStorage riêng cho Taxi, giữ mốc khi tải lại, dừng ở 0 thay vì tự tạo hạn mới. Storage bị chặn thì giữ mốc trong bộ nhớ trang. Không gắn hạn ưu đãi hoặc cam kết nhận xe.
- Lệnh `php scripts/check-pages.php` PASS: bốn route 200, URL không tồn tại 404, không ID trùng, anchor tồn tại, đúng thứ tự section, một popup đăng ký mỗi landing, Taxi đúng ba ảnh giống Bike và tài sản ảnh tồn tại. Đã sửa CTA trên 404 trỏ về `/#dang-ky`.
- `php -l` tất cả file PHP trong app/config/content/public/scripts PASS; `node --check public/assets/js/app.js` PASS. Runtime kiểm tra PHP 8.4.24, chưa chạy trực tiếp PHP 8.2.
- Kiểm tra trên trình duyệt tích hợp tại 360×800, 390×844, 768×1024 và 1440×1000: không tràn ngang; form mobile một cột, điện thoại/Zalo thẳng hàng khi hai cột; footer không bị bottom nav che. Kiểm tra ảnh, CTA, menu Taxi active, support đóng/mở, FAQ, gửi form preview, chuyển form/pháp lý, cuộn nội dung pháp lý với nút Đã hiểu luôn hiện, Escape, Tab/Shift+Tab và trả focus. Đã sửa vòng focus popup sau khi kiểm thử phát hiện lỗi.
- Carousel mobile xếp ba ảnh dọc, không tự chuyển; desktop một ảnh, tự chuyển 7 giây, nút trước/sau và xem lớn hoạt động. Quan sát trang giữ scrollY=0 khi tự chuyển và scrollY=2000 khi đọc section khác. Console không có error/warning tại lần kiểm tra cuối. Bike kiểm tra lại popup hình thức → form giữ lựa chọn, RTO/Van mở được popup chung và active đúng.
- Ảnh QA lưu trong `output/taxi-qa/`; bằng chứng là kiểm tra local, không phải kiểm tra trên điện thoại thật hoặc production.
- Còn thiếu trước vận hành: danh sách khu vực/tổ hợp tuyển dụng được duyệt, required/optional, chính sách thu nhập/chi phí/quyền lợi cụ thể, lịch tham gia, hotline/Zalo và nội dung pháp lý thực tế. Người dùng đã cung cấp danh sách giấy tờ và quyền lợi tham khảo; nội dung áp dụng thực tế theo chương trình/khu vực vẫn cần chốt. Ba ảnh chia sẻ được tái sử dụng theo yêu cầu; chưa xác minh độc lập nguồn/con số trong ảnh. Không có thêm ảnh Taxi cần tạo.
- Database, Telegram, tracking và triển khai production chưa thực hiện trong nhiệm vụ này.

### Bằng chứng triển khai form/database và Telegram queue local — 13/10/2026

- Form chung đã chuyển từ thông báo xem trước sang `POST /api/leads`; có trạng thái đang gửi, lỗi theo trường, lỗi hệ thống không xóa dữ liệu và thành công kèm mã hồ sơ. CSRF theo session, honeypot, giới hạn lượt gửi theo IP hash và submission token chống lặp đã được thêm.
- Required đã cấu hình tập trung: họ tên, điện thoại, tỉnh/thành, phương tiện và loại hình bắt buộc; Zalo và CCCD để trống hợp lệ nhưng UI không gắn nhãn “không bắt buộc”. Danh sách 17 tỉnh/thành theo dữ liệu người dùng cung cấp đã hiển thị trên cả form inline/modal.
- Migration `001_create_leads_and_telegram_jobs.sql` tạo hai bảng InnoDB. Lead và Telegram job được ghi trong cùng transaction; CCCD dùng AES-256-GCM với khóa 32 byte từ `APP_ENCRYPTION_KEY`; UTM/click ID chỉ lưu metadata cho phép.
- `php scripts/test-lead-service.php` PASS: dữ liệu hợp lệ, chuẩn hóa điện thoại, một lead + một job, CCCD không lưu rõ và giải mã đúng, retry cùng token không tạo trùng, dữ liệu sai bị từ chối, Zalo/CCCD trống hợp lệ.
- Kiểm thử endpoint bằng SQLite tạm: lần đầu trả 201 và mã `XS-*`; gửi lại cùng token trả cùng mã với `duplicate=true`; điện thoại sai trả 422 cùng lỗi trường. Database thử đã được xóa sau kiểm tra.
- Worker `cron/send-telegram.php` dùng Bot API gửi vào group qua `TELEGRAM_CHAT_ID`, giữ message ID, named lock chống chạy chồng, phục hồi job processing quá hạn và retry có backoff/failed. Có thể gọi bằng CLI hoặc endpoint `/cron/send-telegram` với header secret/query token. Nội dung theo mẫu người dùng cung cấp và gồm URL nguồn; chưa gọi Telegram thật vì chưa có bot token/group ID.
- Thông báo Telegram dùng HTML an toàn: tiêu đề in đậm và giá trị của từng trường nằm trong thẻ code riêng để nổi bật, hỗ trợ sao chép từng giá trị thuận tiện trên ứng dụng di động. Nhãn giữ dạng văn bản thường; dữ liệu được escape trước khi ghép HTML.
- `php scripts/check-pages.php`, PHP lint toàn dự án và `node --check public/assets/js/app.js` PASS. Trình duyệt mobile 390px không tràn ngang; required và 17 tỉnh/thành đúng; khi DB chưa cấu hình, form báo tạm gián đoạn, giữ nguyên dữ liệu và console không có error/warning.

### Bằng chứng SEO, GTM và tối ưu tải trang local — 13/10/2026

- Title/description của Bike, Taxi, RTO và Van được rút gọn, mỗi title chỉ mô tả đúng trang và không lặp dày tên thương hiệu. Layout sinh robots index/noindex, canonical, Open Graph, Twitter card, favicon và preload ảnh hero; canonical/OG URL chỉ dùng `APP_URL` đã cấu hình.
- `/robots.txt` và `/sitemap.xml` trả đúng content type, liệt kê bốn landing page và chặn bot vào `/api/`, `/cron/`. Local dùng host hiện tại; production bắt buộc đặt `APP_URL` để sinh URL chuẩn.
- GTM chỉ được chèn khi `GTM_ID` đúng dạng `GTM-*`. Kiểm thử với ID giả xác nhận script/iframe được chèn và canonical là domain cấu hình; khi ID trống không có request GTM. Event gồm `form_open`, `form_start`, `generate_lead`, `click_call`, `click_zalo`, `view_bike_details`; không gửi họ tên, điện thoại, Zalo hoặc CCCD. `generate_lead` bỏ qua phản hồi duplicate.
- `.htaccess` bật cache immutable một năm cho tài nguyên có version, Brotli/gzip khi hosting hỗ trợ. Hero eager/fetchpriority và preload; ảnh dưới fold lazy + async decode; font tự host có `font-display: swap`.
- PHP lint, `node --check`, `php scripts/check-pages.php`, kiểm thử lead/Telegram formatter và `git diff --check` đạt. Chưa đo Lighthouse trên production và chưa xác nhận event trong container GTM thật vì chưa có domain/hosting/GTM ID.

### Bằng chứng popup chuyển đổi local — 13/10/2026

- Form chỉ mở popup sau phản hồi `ok` từ endpoint. Lead mới phát `generate_lead` rồi đổi URL sang `/dang-ky-thanh-cong` bằng History API; đóng popup trả URL nguồn, không tải lại trang và không đưa dữ liệu cá nhân vào URL.
- URL thành công mở trực tiếp trả 200, tự mở popup, có `noindex,follow`, canonical về trang Bike và không nằm trong sitemap. Phản hồi trùng không phát event hoặc URL chuyển đổi mới.

### Điều chỉnh giao diện mobile — 13/10/2026

- Giảm chiều cao thanh menu dưới, khoảng cách icon–nhãn và độ nhô nút Đăng ký; giữ vùng chạm lớn hơn 44px cùng safe area. Đồng thời cân lại vị trí bong bóng hỗ trợ và khoảng trống footer theo chiều cao mới.
- Đồng nhất input và select của form inline/modal ở chiều cao 54.4px, toàn chiều rộng cột trên Safari iOS, Chrome Android và trình duyệt nhúng.
- Sau phản hồi về danh sách mở kiểu cũ, select được nâng thành dropdown tùy biến nhẹ dùng CSS/JavaScript thuần. Danh sách có bo góc, bóng, mục đang chọn, cuộn giới hạn; hỗ trợ chuột, cảm ứng, phím mũi tên/Home/End/Enter/Escape và báo lỗi required trên nút điều khiển. Select gốc tiếp tục giữ giá trị submit nhưng được ẩn khỏi cây trợ năng để không tạo điều khiển trùng.

### Điều chỉnh Taxi theo phản hồi hình ảnh — 13/10/2026

- Hero Taxi đã đổi sang cùng lớp bố cục hero Bike: ảnh phủ nền, overlay sáng, chữ và hai CTA đặt trên ảnh, countdown chồng mép dưới 72px. Giữ nguyên ảnh Taxi được cung cấp; Bike không đổi. Tablet 768–1023px thu gọn vùng chữ và điều chỉnh lớp phủ/crop để dễ đọc.
- Cập nhật sáu nhóm quyền lợi và bốn mục giấy tờ theo ảnh tham khảo mới người dùng gửi. Danh sách giấy tờ/FAQ đồng nhất; chưa biến các nội dung nhận xe trong ngày, miễn phí hoặc hỗ trợ 24/7 thành cam kết.
- Kiểm tra lại 360/390/768/1440px, ảnh hero, anchor Xem quyền lợi và CTA đăng ký; không tràn ngang. PHP lint các file sửa và `php scripts/check-pages.php http://127.0.0.1:8173` PASS. Ảnh `output/taxi-qa/*-v2.png` là bản hero mới; ảnh QA không có hậu tố v2 ghi nhận lần triển khai trước phản hồi này.

- Phản hồi cuối: đã bỏ toàn bộ section “Công việc của bạn / Cùng Taxi điện, đón những hành trình mới”, bỏ dữ liệu intro và CSS không dùng; quyền lợi nối ngay sau form. Lint PHP/JS và smoke check bốn route/404/anchor sau thay đổi đều PASS.

### Rà soát nội dung Taxi, RTO và Van — 13/10/2026

- Đã đối chiếu nguồn tuyển dụng Taxi và tin chính sách RTO/Van, giới thiệu dịch vụ Van của Green SM; bảng nguồn và quyết định biên tập ở `docs/CONTENT-AUDIT-2026-10-13.md`. Các trang cũ người dùng cung cấp hiện không tải được qua công cụ tra cứu nên không khẳng định đã đọc nội dung ở đó.
- `content/taxi.php`, `content/rto.php`, `content/van.php` đã viết lại thẻ quyền lợi, phần chính sách trong thẻ/FAQ và quy trình theo cơ chế cụ thể của từng loại hình. Taxi nêu rõ phạm vi tài xế công ty; RTO nêu cấu trúc thuê và mua lại; Van nêu giao nhận hàng, ứng dụng, đào tạo và phạm vi chính sách người mới. Không đăng mức tiền hoặc ưu đãi ngắn hạn.
- Kiểm tra local: PHP lint ba file content PASS; `php scripts/check-pages.php http://127.0.0.1:8186` PASS cho bốn landing, route thành công và 404; `git diff --check` PASS. Chưa kiểm trên production. Trước khi chạy quảng cáo cần xác nhận lại phạm vi khu vực tuyển, hình thức/xe RTO và chính sách đang áp dụng thực tế.

### Dải đồng hồ bốn trang — 13/10/2026

- Theo yêu cầu trực tiếp mới, Taxi, RTO và Van dùng cùng tiêu đề hai dòng đã có trên Bike: “Đăng Ký Ngay” / “Nhận Xe Điện Trong Ngày”. Bỏ dòng ghi chú hiển thị ở dải đồng hồ của ba trang này; không đổi logic đếm ngược hoặc biểu mẫu.
- PHP lint ba view PASS; `php scripts/check-pages.php http://127.0.0.1:8080` PASS cho bốn landing, route thành công và 404; `git diff --check` PASS. Cam kết nhận xe trong ngày chưa được xác thực độc lập cho từng trang/khu vực; cần đối chiếu với năng lực tiếp nhận thực tế trước khi quảng cáo.

### Quyền lợi RTO — 13/10/2026

- Section RTO đổi tiêu đề thành “Quyền lợi của tài xế”, gồm bốn thẻ theo thứ tự: sở hữu xe điện khi đáp ứng chính sách mua lại, đồng phục miễn phí và nhận xe điện, hỗ trợ 24/7, hồ sơ gọn và nhận xe nhanh. Không nêu số tiền trong các thẻ. Thêm icon đồng phục vào component icon chung.
- [Nguồn Green SM về RTO](https://www.greensm.com/vn-vi/news/vao-xanh-tang-xe-cung-chinh-sach-bao-dam-thu-nhap-vo-cung-hap-dan) xác nhận cơ chế mua lại, chương trình đồng phục miễn phí và bước nhận xe sau hồ sơ; hỗ trợ 24/7 là nội dung người dùng trực tiếp yêu cầu theo ảnh tham khảo, chưa xác minh độc lập phạm vi áp dụng. Cần đối chiếu chính sách hiện hành của khu vực trước khi chạy quảng cáo.
- PHP lint `content/rto.php` và `app/views/components/content-icon.php` PASS; kiểm tra đúng bốn thẻ và thứ tự PASS; `php scripts/check-pages.php http://127.0.0.1:8187` PASS khi cấu hình `APP_URL` cho server local. Chưa kiểm trên production.
- Phản hồi tiếp theo: thẻ đầu đổi thành “Chạy xe, sở hữu xe điện” và diễn đạt trực tiếp lợi ích tạo thu nhập song song với tiến tới sở hữu xe. Phần giới thiệu, quy trình và FAQ RTO được trả về bản trước commit rà soát nội dung; phần giấy tờ cùng bốn thẻ quyền lợi mới được giữ nguyên.
