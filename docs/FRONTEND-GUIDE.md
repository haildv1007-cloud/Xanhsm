# Quy chuẩn frontend

Trạng thái: tài liệu bắt buộc đọc trước khi tạo hoặc sửa giao diện. Yêu cầu nội dung và thứ tự section nằm trong `UI-SPEC.md`; tài liệu này quy định cách trình bày nhất quán.

## 1. Định hướng thị giác

- Mobile-first, sáng, thoáng, rõ và thân thiện với người dùng đang xem nhanh trên điện thoại.
- Giao diện có cảm giác thuộc hệ sinh thái Xanh SM qua dải xanh cyan sáng, nền sạch, chữ trung tính dễ đọc và hình ảnh phương tiện/tài xế.
- Ưu tiên khả năng đọc và thao tác. Không làm giao diện quá bóng, quá nhiều gradient, hiệu ứng hoặc badge.
- Mỗi section phải có vai trò riêng; không lặp toàn bộ trang bằng những lưới card giống nhau.
- Nội dung và component là HTML/CSS thật. Không dùng ảnh mockup nguyên trang làm giao diện.

## 2. Hệ màu

### Dải màu thương hiệu chính — đã được người dùng chốt

| Token | Mã màu | Vai trò chính |
| --- | --- | --- |
| `--color-white` | `#FFFFFF` | Nền trang, nền form, nền card và popup |
| `--color-mist` | `#E6FAFB` | Nền section xen kẽ, vùng thông tin nhẹ |
| `--color-aqua-soft` | `#85E9EB` | Viền nổi bật, icon nền, trạng thái hover nhẹ |
| `--color-aqua` | `#00CED3` | CTA chính, điểm nhấn mạnh, tab/menu đang chọn |

Dải màu chính dùng theo thứ tự `#FFFFFF → #E6FAFB → #85E9EB → #00CED3`. `#00CED3` là màu mạnh nhất của giao diện. Chỉ dùng gradient ở mảng nền lớn hoặc điểm nhấn có chủ đích; không phủ gradient lên mọi card và nút.

### Màu chức năng để bảo đảm khả năng đọc

| Token | Mã màu | Vai trò |
| --- | --- | --- |
| `--color-ink` | `#26383A` | Tiêu đề trung tính |
| `--color-text` | `#41595B` | Nội dung chính |
| `--color-text-muted` | `#6B7E80` | Chú thích và nội dung phụ |
| `--color-border` | `#C9EFF0` | Viền mặc định nhẹ |
| `--color-error` | `#B42318` | Lỗi form |
| `--color-success` | `#16794B` | Trạng thái thành công |

Không dùng `#063F43`. Tiêu đề và nội dung dùng xám xanh trung tính để trang không bị tối. CTA chính dùng nền `#00CED3`, chữ trắng và weight 700 theo lựa chọn thương hiệu của người dùng.

### Popup chi tiết Bike

Phần đầu popup chi tiết ba hình thức Bike dùng nền `#00CED3` đồng nhất và chữ trắng theo `UI-SPEC.md`. Không dùng gradient hoặc mảng vàng.

### Tỷ lệ sử dụng gợi ý

- Khoảng 55–65%: trắng.
- Khoảng 20–30%: xanh sương `#E6FAFB`.
- Khoảng 10–15%: `#85E9EB` và `#00CED3` cho điểm nhấn.
- Chữ trung tính đậm được dùng theo nhu cầu đọc, không tính như mảng màu trang trí.

## 3. Typography

- Font chính: **Be Vietnam Pro**, tự host trong `public/assets/fonts/` ở định dạng WOFF2.
- Chỉ tải các weight `400`, `600`, `700`; khai báo `font-display: swap`.
- Fallback: `"Segoe UI", Arial, sans-serif`.
- Không dùng font viết tay, font trang trí hoặc nhiều họ font trên cùng website.

| Thành phần | Mobile | Desktop | Weight |
| --- | --- | --- | --- |
| H1 hero | `34–40px` | `52–64px` | 700 |
| H2 section | `26–30px` | `36–44px` | 700 |
| H3/card | `18–20px` | `20–24px` | 600–700 |
| Nội dung | `16px` | `16–18px` | 400 |
| Nhãn form/nút | `15–17px` | `15–17px` | 600–700 |
| Chú thích | `13–14px` | `14px` | 400 |

- Line-height nội dung `1.55–1.7`; tiêu đề `1.12–1.25`.
- H1 tối đa khoảng 15 ký tự theo chiều ngang (`15ch`) khi bố cục cho phép.
- Không dùng toàn bộ chữ in hoa cho câu dài. Eyebrow có thể in hoa nhưng phải ngắn.

## 4. Lưới, chiều rộng và khoảng cách

- Container desktop tối đa `1200px`, căn giữa.
- Padding ngang: mobile `16px`, tablet `24–32px`, desktop tối thiểu `32px`.
- Breakpoint tham khảo: `480px`, `768px`, `1024px`, `1280px`. Component quyết định theo không gian thực tế, không tạo breakpoint tùy tiện cho từng trang.
- Khoảng cách section: mobile `56–72px`, desktop `80–104px`.
- Hệ khoảng cách ưu tiên bội số 4: `4, 8, 12, 16, 24, 32, 48, 64, 80, 96px`.
- Nội dung đọc dài giới hạn khoảng `65ch`; form và popup không kéo quá rộng.

## 5. Hình khối và độ sâu

- Bo góc input/button: `12–14px`.
- Bo góc card/form: `16–20px`.
- Bo góc mảng hero/popup lớn: tối đa `24–28px`.
- Viền mặc định `1px solid #C9EFF0`.
- Shadow rất nhẹ, thiên xanh đậm với opacity thấp; không xếp nhiều lớp bóng hoặc glow.
- Card cùng loại phải thống nhất chiều cao, padding và cách đặt icon.

## 6. Header và điều hướng

- Mobile: header gọn, logo rõ; thanh menu cố định dưới màn hình theo thứ tự `Bike | Taxi | Đăng ký | RTO | Van` được hoàn thiện trong giai đoạn 2.
- “Đăng ký” là mục nổi bật; mục trang hiện tại có trạng thái active dùng nền/đường nhấn aqua.
- Desktop: logo trái, điều hướng giữa/phải, CTA đăng ký rõ; không cần bottom navigation.
- Sticky header không được chiếm quá nhiều chiều cao hoặc che anchor khi cuộn.

## 7. Hero

- Mobile: nội dung trước, hình ảnh sau; CTA nằm trong vùng nhìn đầu tiên nếu chiều cao màn hình cho phép.
- Desktop: hai cột, nội dung trái và ảnh phải. Không nhét form vào cùng một khối hero.
- Tiêu đề ngắn, mô tả 2–3 dòng, một CTA chính và tối đa một liên kết phụ.
- Ảnh phải hỗ trợ câu chuyện của từng loại hình, không chứa lượng chữ lớn và không dùng ảnh chưa được phép xuất bản.
- Có thể dùng nền `#E6FAFB` hoặc gradient nhẹ trong dải màu đã chốt; tránh gradient bão hòa.

## 8. Button và liên kết

- Primary: nền `#00CED3`, chữ trắng, hover tối nhẹ trong cùng sắc cyan.
- Secondary: nền trắng, chữ và viền `#00CED3`.
- Text link: chữ `#00CED3`, underline/biểu tượng hướng rõ; không dựa riêng vào màu để biểu thị tương tác.
- Chiều cao tối thiểu button `52px` cho CTA chính; vùng chạm tối thiểu `44 × 44px`.
- Không dùng nhiều hơn một CTA primary trong cùng một cụm hành động.
- Disabled phải khác biệt rõ và không chỉ giảm opacity quá thấp.

## 9. Form

- Form nền trắng, viền xanh nhạt và shadow nhẹ; không đặt trực tiếp lên ảnh.
- Một cột trên mobile; desktop có thể hai cột. Trường dài/loại hình có thể chiếm cả hàng.
- Label luôn hiển thị phía trên input; placeholder chỉ là ví dụ, không thay label.
- Input/select cao `52–56px`, chữ tối thiểu `16px` để tránh zoom ngoài ý muốn trên mobile.
- Focus dùng outline rõ bằng xanh đậm/aqua; lỗi nằm ngay dưới trường và có liên kết ngữ nghĩa.
- Nút gửi rộng toàn hàng trên mobile. Trạng thái đang gửi, lỗi và thành công phải rõ.
- Form inline và modal dùng chung component, token, quy tắc validate và nội dung.

## 10. Section và component

- Lợi ích: card trắng trên nền `#E6FAFB`, icon aqua, chữ xanh đậm; không có nút/mũi tên khi chỉ là nội dung.
- Giấy tờ: danh sách rõ với dấu kiểm hoặc số thứ tự, không biến thành thêm một lưới lợi ích.
- Quy trình: dùng số bước `01`, `02`, `03` và đường dẫn thị giác nhẹ.
- Chia sẻ tài xế: mobile xếp ba ảnh từ trên xuống dưới và không tự chuyển; desktop dùng carousel một ảnh mỗi lượt, tự chuyển sau 7 giây. Ảnh mở lớn khi bấm.
- FAQ: accordion native/accessibility-friendly, vùng bấm đủ lớn.
- Footer: nền `#00CED3`, chữ trắng; dòng tư cách đơn vị phải đúng nguyên văn trong `UI-SPEC.md`.

## 11. Modal và bong bóng hỗ trợ

- Modal luôn ở giữa viewport, mobile chừa tối thiểu `16px` hai bên, desktop rộng khoảng `560–680px`.
- Giới hạn chiều cao `85–90dvh`, cuộn nội dung bên trong, khóa cuộn nền và quản lý focus.
- Nút đóng có nhãn truy cập, vùng chạm tối thiểu `44px`; hỗ trợ Escape và trả focus về nút mở.
- Không xếp chồng modal. Popup chi tiết Bike phải đóng trước khi mở form.
- Bong bóng hỗ trợ không che CTA, form hoặc bottom navigation; có thể thu gọn/đóng và bật tắt bằng config.

## 12. Ảnh và icon

- Ưu tiên ảnh thật đã được phép dùng; chuẩn bị kích thước riêng cho mobile/desktop.
- Xuất WebP/AVIF khi phù hợp, có width/height để tránh nhảy bố cục; hero tải ưu tiên, ảnh dưới fold lazy-load.
- Icon dùng SVG cùng một phong cách nét/khối; không trộn nhiều bộ icon.
- Luôn có alt có ích cho ảnh mang nội dung; ảnh trang trí dùng alt rỗng.
- Không dùng ảnh concept, ảnh thu nhập hoặc khuôn mặt trong tài liệu tham khảo làm nội dung xuất bản nếu chưa có quyền.

## 13. Chuyển động và khả năng truy cập

- Chỉ dùng fade/translate nhẹ, hover và accordion/modal transition ngắn khoảng `150–250ms`.
- Không dùng parallax, video nền, animation lặp liên tục hoặc hiệu ứng làm chậm CTA.
- Tôn trọng `prefers-reduced-motion`.
- Giữ thứ tự heading đúng, focus nhìn thấy, semantic HTML và thao tác được bằng bàn phím.
- Kiểm tra tối thiểu ở 360px, 390px, 768px và desktop; không tràn ngang hoặc bị menu che.

## 14. Token CSS chuẩn

```css
:root {
  --color-white: #FFFFFF;
  --color-mist: #E6FAFB;
  --color-aqua-soft: #85E9EB;
  --color-aqua: #00CED3;
  --color-ink: #26383A;
  --color-text: #41595B;
  --color-text-muted: #6B7E80;
  --color-border: #C9EFF0;
  --color-error: #B42318;
  --color-success: #16794B;
}
```

AI không được tự thay dải màu chính hoặc tạo thêm màu thương hiệu mới. Nếu cần một màu trạng thái ngoài bảng trên, dùng màu chức năng tối thiểu, kiểm tra độ tương phản và ghi lại lý do trong báo cáo thay đổi.

## 15. Triển khai Taxi local

- Hero Taxi dùng lại toàn bộ hệ class hero Bike theo yêu cầu sửa mới nhất: ảnh nền phủ khối, lớp phủ trắng chuyển sắc, nội dung và hai nút trên ảnh, countdown chồng 72px ở mép dưới. Chỉ chỉnh vị trí crop ảnh Taxi (mobile 80% ngang, desktop giữa); không thay hero Bike. Quyết định này thay cách chia hai khối ảnh/chữ ở bản Taxi đầu tiên và là ngoại lệ của mục 7.
- Sáu thẻ quyền lợi dùng một cột ở mobile hẹp và hai cột từ 640px; cỡ chữ nội dung 16px. Bốn mục giấy tờ dùng component danh sách chung. Các section còn lại tái sử dụng component Bike.
- Ba ảnh chia sẻ giống Bike theo yêu cầu mới nhất: dưới 768px xếp dọc, từ 768px carousel một ảnh mỗi lượt/7 giây; reduced motion ngừng tự chuyển. Chỉ cuộn ngang bên trong track.
- Modal đăng ký dùng grid để phần đầu luôn nhìn thấy, phần form cuộn bên trong. Tab/Shift+Tab giới hạn trong modal; mở pháp lý từ form sẽ tạm đóng form và quay lại khi đóng pháp lý. Escape và nút đóng trả focus đúng nút mở.
