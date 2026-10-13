# Prompt cho các phiên triển khai giai đoạn 3

Nên chạy các phiên theo thứ tự **Taxi → RTO → Van → rà soát tích hợp**. Các trang dùng chung layout, component, CSS, JavaScript và form nên không chạy đồng thời trong cùng một working tree.

## 1. Trang Taxi

```text
Hãy tiếp tục dự án website đăng ký tài xế trong workspace hiện tại và hoàn thiện trang Taxi tại `/taxi`.

Trước khi sửa code, bắt buộc đọc đầy đủ các file sau để nắm yêu cầu và định hướng đã chốt:
- `AGENTS.md`
- `docs/UI-SPEC.md`
- `docs/FRONTEND-GUIDE.md`
- `docs/TECH-SPEC.md`
- `docs/IMAGE-ASSETS.md`
- `README.md`

Sau đó kiểm tra toàn bộ hiện trạng code liên quan, đặc biệt:
- `app/views/pages/bike.php` để lấy trang Bike đã hoàn thiện làm chuẩn chất lượng và tương tác;
- `app/views/pages/landing.php`, `app/views/layouts/app.php`, các component trong `app/views/components/`;
- `content/bike.php`, `content/taxi.php`, `config/site.php`, `config/forms.php`;
- `public/assets/css/app.css`, `public/assets/js/app.js`;
- ảnh tham chiếu `output/mobile-demo-v5/02-taxi-mobile.png` chỉ để tham khảo thị giác, không coi nội dung trong ảnh là chính sách đã xác minh.

Hãy triển khai hoàn chỉnh giao diện và tương tác trang Taxi, không chỉ lập kế hoạch. Tái sử dụng và nếu cần thì tổng quát hóa component của Bike; không sao chép thành những phiên bản riêng dễ lệch nhau. Giữ nguyên chất lượng và các quyết định người dùng đã duyệt ở trang Bike. Không làm hỏng `/`, `/rto` hoặc `/van`.

Trang Taxi phải theo đúng thứ tự section trong `docs/UI-SPEC.md`: hero, countdown 8 giờ ở chế độ demo hiện tại, form đăng ký trực tiếp, thông tin loại hình/lợi ích/chính sách và thu nhập tham khảo, giấy tờ cần chuẩn bị, quy trình đăng ký, ba ảnh chia sẻ tài xế, FAQ và footer. Taxi không có cụm ba hình thức và popup chi tiết đặc thù của Bike.

Viết nội dung ngắn, dễ đọc, giúp tài xế thấy việc đăng ký đơn giản. Tránh các cách diễn đạt nặng về kiểm tra, xác minh, điều kiện hoặc thỏa thuận. Không bịa thu nhập, thưởng, chi phí, chính sách, khu vực tuyển, giấy phép hoặc cam kết. Chỗ chưa có dữ liệu thật dùng nội dung trung tính và ghi rõ trong báo cáo bàn giao. Không dùng thông tin cá nhân trong ảnh tham khảo.

Form inline và popup phải dùng component chung hiện có. Popup là biểu mẫu chung nên tiêu đề chỉ là “Đăng ký nhận tư vấn”, không thêm “Taxi” hay tên loại hình. Cấu hình chọn sẵn phương tiện chỉ thực hiện khi ánh xạ đã rõ; không tự đoán tổ hợp loại hình hợp lệ. Chính sách bảo mật và điều khoản tiếp tục dùng popup chung, nút “Đã hiểu” luôn nhìn thấy.

Đảm bảo header, menu mobile theo thứ tự Bike | Taxi | Đăng ký | RTO | Van, trạng thái Taxi active, bong bóng hỗ trợ, popup, form và footer hoạt động thống nhất trên trang Taxi. Nếu layout hiện chỉ nạp các component này cho Bike, hãy tổng quát hóa thành dùng chung cho bốn landing page thay vì thêm điều kiện riêng lẻ.

Hình ảnh phải phù hợp Taxi, không dùng lại ảnh xe máy như ảnh chính. Ưu tiên tài sản đã có và được phép dùng; nếu thiếu ảnh phù hợp, có thể tạo ảnh minh họa mới theo định hướng `FRONTEND-GUIDE.md`, tối ưu WebP và cập nhật `docs/IMAGE-ASSETS.md`. Không dùng ảnh mockup nguyên trang làm giao diện.

Tự chạy kiểm tra phù hợp: PHP lint, kiểm tra bốn route và 404, thao tác form/modal/menu/FAQ, kiểm tra không lỗi console, và kiểm tra thị giác ở 360px, 390px cùng desktop. Không để tràn ngang, khoảng trắng bất thường, nội dung bị bottom nav hoặc bong bóng hỗ trợ che. Trang chia sẻ trên mobile xếp ba ảnh dọc; desktop mới dùng carousel một ảnh mỗi lượt và tự chuyển sau 7 giây. Không để carousel tự kéo trang xuống khu vực chia sẻ.

Sau khi hoàn tất, cập nhật nội dung/trạng thái liên quan trong tài liệu chính nếu quyết định hoặc tiến độ đã thay đổi. Báo cáo ngắn: file đã sửa, hành vi đã hoàn thiện, kiểm tra đã chạy, dữ liệu hoặc ảnh thật còn thiếu. Không báo hoàn tất phần backend/database/Telegram vì giai đoạn này chỉ là giao diện local.
```

## 2. Trang RTO

```text
Hãy tiếp tục dự án trong workspace hiện tại và hoàn thiện trang RTO tại `/rto`. Đây là phiên tiếp nối sau trang Bike và Taxi, vì vậy phải giữ toàn bộ thay đổi hiện có và không khôi phục code cũ.

Trước khi sửa code, bắt buộc đọc đầy đủ:
- `AGENTS.md`
- `docs/UI-SPEC.md`
- `docs/FRONTEND-GUIDE.md`
- `docs/TECH-SPEC.md`
- `docs/IMAGE-ASSETS.md`
- `README.md`

Kiểm tra hiện trạng thực tế của `/`, `/taxi`, `/rto`, `/van` và các file `app/views/`, `content/`, `config/`, `public/assets/css/app.css`, `public/assets/js/app.js`. Dùng trang Bike và trang Taxi đã hoàn thiện làm chuẩn component, responsive, popup và tương tác. Xem `output/mobile-demo-v5/03-rto-mobile.png` như tham khảo thị giác בלבד; đặc tả chữ trong tài liệu và yêu cầu mới nhất của người dùng có ưu tiên cao hơn.

Hãy triển khai đầy đủ trang RTO, không dừng ở kế hoạch. RTO là “thuê xe sở hữu”: giải thích rõ loại hình này là gì, phù hợp với ai, cách tham gia và lộ trình vận hành ở mức khái quát. Không biến trang thành bảng giá hoặc lời hứa sở hữu xe. Không tự nêu cọc, giá thuê, thời hạn, tỷ lệ chia sẻ, thu nhập, thưởng, miễn phí, loại xe cụ thể hoặc điều kiện tài chính khi chưa có dữ liệu được duyệt.

Giữ đúng thứ tự section trong `docs/UI-SPEC.md`: hero, countdown, form trực tiếp, thông tin loại hình/lợi ích/chính sách tham khảo, giấy tờ, quy trình, ba ảnh chia sẻ, FAQ và footer. Trang độc lập RTO không dùng cụm ba thẻ hình thức và popup chi tiết chỉ dành cho Bike.

Nội dung phải thân thiện, rõ ràng và làm cho quy trình đăng ký dễ hiểu. Giảm các từ gây cảm giác khó tham gia như “kiểm tra”, “xác minh”, “điều kiện”, “thỏa thuận”; chỉ dùng khi thật sự cần và có cơ sở. Không bịa giấy tờ hoặc điều kiện bằng lái. Với thông tin chưa chốt, dùng câu trung tính như “được tư vấn theo chương trình và khu vực” rồi liệt kê ở báo cáo bàn giao, không đưa ghi chú kỹ thuật vào trải nghiệm người dùng.

Tái sử dụng component và dữ liệu có cấu trúc; không tạo bản sao form, legal modal, support bubble, mobile nav, FAQ hoặc carousel. Popup form chung phải có tiêu đề “Đăng ký nhận tư vấn”, không gắn chữ RTO. Chỉ chọn sẵn phương tiện/loại hình khi cấu hình xác nhận ánh xạ; đặc biệt không giả định RTO luôn là xe máy. Nếu cấu hình hiện chưa biểu diễn được phương tiện RTO, giữ lựa chọn cho người dùng và ghi rõ điểm còn chờ.

Hình ảnh phải kể đúng câu chuyện thuê xe sở hữu nhưng không thể hiện giá hoặc cam kết bằng chữ trong ảnh. Nếu tạo tài sản mới, tối ưu WebP, khai báo kích thước, alt phù hợp và cập nhật `docs/IMAGE-ASSETS.md`.

Tự kiểm tra PHP lint, bốn route và 404, menu active RTO, form inline/modal, legal modal, hỗ trợ, FAQ, ảnh chia sẻ và console. Kiểm tra 360px, 390px và desktop; không tràn ngang, không có khoảng trắng bất thường, không bị menu/bong bóng che. Mobile xếp ba ảnh chia sẻ dọc; desktop carousel 7 giây và không được tự cuộn trang tới section chia sẻ.

Kết thúc bằng việc cập nhật tài liệu/trạng thái liên quan nếu cần và báo cáo file đã sửa, kiểm tra đã chạy, nội dung thật còn chờ. Không triển khai hoặc tuyên bố hoàn tất database, Telegram hay production hosting trong nhiệm vụ này.
```

## 3. Trang Van

```text
Hãy tiếp tục dự án trong workspace hiện tại và hoàn thiện trang Xanh Van tại `/van`. Giữ nguyên tất cả phần đã hoàn thiện của Bike, Taxi và RTO; kiểm tra code thực tế trước khi sửa để không ghi đè các thay đổi mới hơn.

Trước khi code, bắt buộc đọc đầy đủ:
- `AGENTS.md`
- `docs/UI-SPEC.md`
- `docs/FRONTEND-GUIDE.md`
- `docs/TECH-SPEC.md`
- `docs/IMAGE-ASSETS.md`
- `README.md`

Sau đó rà `app/views/`, `content/van.php`, các content trang đã hoàn thiện, `config/site.php`, `config/forms.php`, CSS và JavaScript dùng chung. Dùng Bike/Taxi/RTO làm chuẩn chất lượng. Chỉ tham khảo bố cục của `output/mobile-demo-v5/04-van-mobile.png`; không sao chép chính sách hoặc con số từ ảnh.

Triển khai hoàn chỉnh giao diện và tương tác trang Van, không chỉ đề xuất. Giải thích rõ loại hình vận hành xe van, đối tượng phù hợp và trải nghiệm đăng ký ở mức dễ hiểu. Không tự suy diễn hoạt động chở hàng, tuyến chạy, tải trọng, bằng lái, phương tiện được cấp, chi phí, thu nhập, thưởng, khu vực hoặc điều kiện tuyển khi chưa có nguồn được duyệt.

Giữ đúng thứ tự section: hero, countdown, form trực tiếp, thông tin loại hình/lợi ích/chính sách và thu nhập tham khảo, giấy tờ, quy trình, ba ảnh chia sẻ tài xế, FAQ và footer. Van không có ba thẻ hình thức và popup chi tiết riêng của Bike.

Viết nội dung ngắn, trực tiếp, thân thiện; mô tả cách bắt đầu đơn giản và tránh lặp các từ “kiểm tra”, “xác minh”, “điều kiện”, “thỏa thuận”. Không bịa cam kết. Dữ liệu chưa được cung cấp phải được diễn đạt trung tính và ghi trong báo cáo bàn giao.

Tiếp tục dùng các component chung đã có. Không nhân bản form, modal pháp lý, menu, hỗ trợ, FAQ hoặc carousel. Popup form là biểu mẫu chung với tiêu đề “Đăng ký nhận tư vấn”, không có chữ Van. Có thể chọn sẵn “Xe van” khi cấu hình và ngữ cảnh trang xác nhận rõ, nhưng không tự chọn loại hình Công ty/Platform/RTO nếu tổ hợp chưa được chốt.

Hình ảnh chính phải là xe van/tài xế phù hợp, không dùng ảnh xe máy hoặc taxi làm hero. Nếu cần tạo ảnh mới, tuân thủ `FRONTEND-GUIDE.md`, không logo/chữ/watermark/biển số đọc được, tối ưu WebP và cập nhật `docs/IMAGE-ASSETS.md`.

Tự kiểm tra PHP lint, bốn route và 404, menu active Van, form inline/modal, popup pháp lý, support bubble, FAQ, carousel, console và responsive ở 360px, 390px, desktop. Không để tràn ngang, khoảng trắng lớn, ảnh sai tỷ lệ hoặc bottom nav/bong bóng che nội dung. Mobile hiển thị ba ảnh chia sẻ theo chiều dọc; desktop mới carousel một ảnh mỗi lượt sau 7 giây và không được tự kéo vị trí cuộn.

Sau khi hoàn tất, cập nhật tài liệu/trạng thái liên quan nếu cần và báo cáo ngắn phần đã làm, kiểm tra đã chạy, dữ liệu/ảnh thật còn thiếu. Phạm vi vẫn là giao diện local, chưa phải backend, Telegram hay triển khai production.
```

## 4. Rà soát tích hợp sau ba trang

```text
Hãy thực hiện một lượt rà soát tích hợp giai đoạn 3 cho toàn bộ website sau khi các trang Bike, Taxi, RTO và Van đã được hoàn thiện. Đây là nhiệm vụ kiểm tra và sửa lỗi thực tế, không chỉ review bằng lời.

Đầu tiên đọc `AGENTS.md`, `docs/UI-SPEC.md`, `docs/FRONTEND-GUIDE.md`, `docs/TECH-SPEC.md`, `docs/IMAGE-ASSETS.md`, `README.md`, rồi kiểm tra toàn bộ code và lịch sử thay đổi hiện có. Yêu cầu mới nhất và trạng thái code thực tế được ưu tiên; không khôi phục phiên bản cũ của trang Bike.

Rà cả bốn URL `/`, `/taxi`, `/rto`, `/van` và một URL 404. Đảm bảo bốn trang dùng chung component, form, legal modal, header/footer, support bubble và mobile nav; không còn bản sao lệch nội dung hoặc xử lý. Popup form ở mọi trang phải mang tiêu đề chung “Đăng ký nhận tư vấn”. Chỉ Bike có ba thẻ hình thức và popup chi tiết Chính sách – Quy trình – Hỏi đáp.

Kiểm tra thứ tự section, active navigation, CTA/anchor, dữ liệu chọn sẵn, mở/đóng modal, Escape/focus, khóa cuộn nền, FAQ, legal modal với nút “Đã hiểu” luôn thấy, hỗ trợ Gọi/Zalo và carousel. Mobile phải xếp ba ảnh chia sẻ dọc; desktop carousel một ảnh mỗi lượt sau 7 giây. Sửa triệt để mọi logic khiến trang tự cuộn xuống section chia sẻ khi tải trang hoặc trong lúc người dùng đang đọc.

Kiểm tra thị giác ở 360px, 390px, 768px và desktop: không tràn ngang, không khoảng trắng bất thường, không ảnh méo, không menu/bong bóng che CTA, form hoặc footer. Rà icon Bike/Taxi/RTO/Van đúng loại phương tiện và cùng phong cách. Rà nội dung để loại bỏ cam kết hoặc con số chưa xác minh, thông tin cá nhân từ ảnh, và cách viết nặng về kiểm tra/xác minh/điều kiện.

Chạy PHP lint và các kiểm tra dự án hiện có; kiểm tra console trình duyệt và các tương tác chính. Chỉ sửa trong phạm vi cần thiết, không bắt đầu backend/database/Telegram. Sau khi mọi kiểm tra phù hợp đều đạt, cập nhật bảng tiến độ giai đoạn 3 trong `docs/TECH-SPEC.md` với bằng chứng đúng sự thật và cập nhật `README.md` nếu trạng thái dự án thay đổi.

Báo cáo cuối gồm: lỗi đã tìm thấy và sửa, file chính đã thay đổi, kích thước màn hình đã kiểm tra, lệnh kiểm tra/kết quả, nội dung hoặc cấu hình còn chờ người dùng cung cấp.
```
