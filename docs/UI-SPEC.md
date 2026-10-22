# Đặc tả giao diện và nội dung

Trạng thái: tổng hợp các quyết định đã chốt với người dùng. Đây là yêu cầu triển khai; bộ ảnh v5 chỉ là concept.

## 1. Nhận diện và cách viết

- Phong cách Xanh SM: trắng, dải xanh cyan sáng, chữ trung tính dễ đọc; bố cục thoáng, rõ và dễ đọc trên điện thoại.
- Dải màu thương hiệu chính đã chốt: `#FFFFFF`, `#E6FAFB`, `#85E9EB`, `#00CED3`. `#00CED3` là màu mạnh nhất; không dùng `#063F43`. Phân vai màu, typography, kích thước và quy tắc component nằm trong `FRONTEND-GUIDE.md`.
- CTA và điểm nhấn mạnh dùng nền `#00CED3`, chữ trắng. Nội dung thường dùng màu trung tính theo `FRONTEND-GUIDE.md`.
- Popup chi tiết ba hình thức Bike dùng nền xanh cyan đồng nhất và chữ trắng ở phần đầu, không dùng gradient hoặc mảng vàng. Giữ màu vốn có của logo/ảnh thương hiệu.
- Website của đơn vị liên kết tuyển dụng. Không tự xưng chính thức; không thêm cảnh báo phủ định hoặc badge về tư cách đơn vị ở nhiều chỗ.
- Dùng ngôn ngữ ngắn, trực tiếp; chính sách/thu nhập chỉ nêu khi có thông tin được duyệt, kèm ngữ cảnh “tham khảo”, “tùy khu vực”, “theo điều kiện áp dụng” ở vị trí phù hợp.
- Không sao chép các cam kết “100%”, thu nhập đảm bảo hoặc ưu đãi trong ảnh tham khảo thành thông tin đã xác thực. Riêng quyền lợi đồng phục miễn phí và hỗ trợ 24/7 trên RTO cùng dòng “Nhận Xe Điện Trong Ngày” tại dải đồng hồ là nội dung người dùng yêu cầu trực tiếp; cần xác nhận phạm vi áp dụng thực tế trước khi quảng cáo.

## 2. Trang và thứ tự nội dung

| URL | Trang | Ghi chú |
| --- | --- | --- |
| `/` | Bike | Trang chủ, ưu tiên kinh doanh Bike |
| `/taxi` | Taxi | Landing page riêng |
| `/rto` | RTO | Thuê xe sở hữu; phương tiện cụ thể cần cấu hình theo chương trình thực tế |
| `/van` | Xanh Van | Landing page riêng |

Thứ tự trên cả mobile và desktop:

1. Hero: tiêu đề, mô tả ngắn, ảnh phù hợp và CTA đăng ký.
2. Đồng hồ đếm ngược tám tiếng, vị trí ngay sau hero.
3. Form đăng ký trực tiếp trên trang.
4. Thông tin loại hình, lợi ích/quyền lợi, chính sách và thu nhập tham khảo.
5. Riêng Bike: ba thẻ tìm hiểu hình thức tham gia, đặt trước phần quyền lợi.
6. Quyền lợi dành cho tài xế Bike.
7. Giấy tờ cần chuẩn bị.
8. Quy trình đăng ký.
9. Chia sẻ tài xế kèm ảnh thu nhập, khoảng ba mục.
10. FAQ.
11. Footer.

Không thay phần lợi ích bằng danh sách liên kết sang trang khác. Giấy tờ phải phù hợp từng loại hình; không tự xác nhận điều kiện bằng lái hoặc giấy tờ thay thế từ ảnh tham khảo.

## 3. Lợi ích nổi bật trên cả bốn trang

- Thẻ trắng trên nền xanh nhạt, tiêu đề lớn/đậm, icon turquoise, chữ xanh đậm.
- Nội dung đọc trực tiếp, không có mũi tên điều hướng hay nút chuyển trang trên từng thẻ.
- Có thể dùng lưới 2 × 2 nếu đủ rộng; mobile hẹp chuyển một cột khi cần để giữ chữ dễ đọc.
- Nhấn thông tin hữu ích: phương tiện, hỗ trợ, cách tham gia, chính sách theo khu vực. Con số chỉ dùng khi đã được cung cấp/xác minh.

## 4. Ba thẻ và popup chi tiết chỉ dành cho Bike

Đặt sau lợi ích, trước giấy tờ. Tiêu đề: “Bạn muốn tham gia theo hình thức nào?”.

| Thẻ | Đối tượng | Hành động |
| --- | --- | --- |
| Thuê xe sở hữu | Tìm hiểu phương án RTO | Mở popup chi tiết RTO |
| Chạy xe công ty | Chưa có xe | Mở popup chi tiết công ty |
| Platform | Đã có xe | Mở popup chi tiết Platform |

- Thẻ có ảnh, mô tả ngắn, nút “Xem chi tiết”; dùng trắng/xanh, không dùng vàng.
- Mobile xếp dọc để rõ; desktop có thể ba cột.
- Bấm mở popup giữa màn hình, không chuyển trang.
- Bên trong popup dùng điểm nhấn xanh cyan; làm rõ bản chất loại hình, điểm khác biệt và có ba tab Chính sách – Quy trình – Hỏi đáp. Nội dung tiền bạc chỉ nêu khái quát, không biến thành cam kết.
- Nút “Đăng ký hình thức này” đóng popup chi tiết rồi mở form chung, chọn sẵn hình thức và giữ dữ liệu đã nhập. Không xếp chồng hai modal.
- Nội dung ba popup dùng từ “chọn” cho các quyết định của tài xế. Với hình thức chạy xe công ty, tài xế chọn mẫu xe và lịch nhận xe trong các phương án tại khu vực đăng ký; không dùng cách diễn đạt “xe được bố trí”, “trao đổi” hoặc “được tư vấn” khiến người đọc hiểu rằng họ không được lựa chọn.

## 5. Form dùng chung

Cả form trực tiếp và form popup trên bốn trang dùng cùng định nghĩa, kiểm tra dữ liệu và endpoint.

- Input và select có cùng chiều cao, khoảng đệm và bề rộng trên mobile lẫn desktop. Select dùng dropdown tùy biến nhẹ bằng CSS/JavaScript thuần: mũi tên riêng, danh sách bo góc, mục đang chọn nổi bật, giới hạn chiều cao và cuộn bên trong; hỗ trợ chuột, cảm ứng và bàn phím. Thẻ select gốc vẫn giữ trong form để submit và xác thực dữ liệu.

| Trường | Cách trình bày |
| --- | --- |
| Họ tên | Ô nhập có nhãn |
| Số điện thoại | Bàn phím điện thoại trên mobile |
| Zalo | Ô số liên hệ; có thể hỗ trợ chọn dùng số điện thoại đã nhập |
| CCCD | Ô dạng chuỗi; không dùng kiểu số làm mất số 0 đầu |
| Khu vực đăng ký | Danh sách từ cấu hình |
| Phương tiện | Danh sách từ cấu hình |
| Loại hình | Công ty / Platform / RTO |

Nhãn loại hình đầy đủ:

- “RTO — thuê xe sở hữu”.
- “Chạy xe công ty — chưa có xe”.
- “Platform — có xe sẵn”.

Thứ tự hiển thị loại hình trong form và ba thẻ “Lựa chọn phù hợp” của Bike: **RTO → Chạy xe công ty → Platform**.

Trang hiện tại chỉ chọn sẵn giá trị khi có ánh xạ rõ ràng; không suy đoán RTO luôn là Bike. Tổ hợp khu vực/phương tiện/loại hình hợp lệ phải được cấu hình và kiểm tra ở server.

- Có trạng thái đang gửi, lỗi từng trường và thành công; lỗi không xóa dữ liệu đã nhập.
- Khi server xác nhận lưu hồ sơ mới, đóng form và mở popup “Đã gửi thông tin tư vấn”; nhân viên sẽ liên hệ trong thời gian sớm nhất. Popup hiển thị mã hồ sơ khi có.
- Trong lúc popup thành công mở, History API đổi URL thành `/dang-ky-thanh-cong` mà không tải lại hoặc chuyển khách sang trang khác. Đóng popup khôi phục URL trước đó; mở trực tiếp đường dẫn này vẫn hiển thị popup và được đặt `noindex`.
- Phản hồi submission trùng vẫn cho người dùng biết hồ sơ đã được tiếp nhận nhưng không tạo URL/event chuyển đổi mới.
- Có dòng đồng ý liên hệ và liên kết chính sách bảo mật, trình bày gọn.
- Không lưu CCCD hay toàn bộ dữ liệu form vào localStorage hoặc URL.
- Họ tên, số điện thoại, tỉnh/thành, phương tiện và loại hình là bắt buộc. Zalo và CCCD không bắt buộc; giao diện giữ nhãn bình thường, không thêm chữ “không bắt buộc”.
- Tỉnh/thành cấu hình hiện tại: Hà Nội, Hồ Chí Minh, Đà Nẵng, Đồng Nai, Bình Dương, Nha Trang, Quảng Ninh, Vũng Tàu, Vinh, Huế, Hải Phòng, Thái Nguyên, Bắc Ninh, Thanh Hoá, Long An, Tây Ninh và Cần Thơ.

## 6. Popup, mobile menu và hỗ trợ

- Popup form và popup chi tiết nằm giữa viewport trên mọi kích thước, không dùng bottom sheet.
- Chính sách bảo mật và điều khoản sử dụng dùng một popup chung trên cả bốn trang. Nội dung cuộn độc lập; nút “Đã hiểu” luôn nằm cố định ở đáy popup.
- Có nền mờ, nút đóng rõ, giới hạn chiều cao theo màn hình, cuộn bên trong khi cần.
- Nút đóng popup trên mobile dùng vòng tròn gọn, không có vòng focus kép nhô lớn; trạng thái focus vẫn hiển thị bên trong nút.
- Popup dùng kích thước theo viewport thực, không tràn hoặc lệch khỏi màn hình trên Safari iOS, Chrome Android và trình duyệt nhúng trong ứng dụng; tắt cơ chế tự phóng chữ làm sai bố cục.
- Khóa cuộn nền; quản lý focus, phím Escape và trả focus về nút mở. Khi bàn phím mobile mở, ô đang nhập và nút gửi vẫn tiếp cận được.
- Mobile có thanh menu cố định dưới cùng, đúng thứ tự: **Bike | Taxi | Đăng ký | RTO | Van**.
- Thanh menu dưới dùng chiều cao gọn, icon và nhãn sát nhau; vẫn giữ vùng chạm tối thiểu dễ thao tác và phần safe area của thiết bị.
- Bốn mục loại hình chuyển trang; “Đăng ký” mở popup form. Có trạng thái trang đang xem.
- Chừa khoảng trống dưới nội dung và safe area để menu không che footer/nút.
- Bong bóng hỗ trợ mở lựa chọn Gọi/Zalo, có đóng/thu gọn và công tắc cấu hình. Không tự bật popup gây cản trở nhập form.
- Desktop giữ thứ tự nội dung, bố cục thích ứng và CTA rõ; không bắt buộc dùng thanh menu cố định như mobile.

## 7. Countdown, chia sẻ và footer

- Countdown có thời lượng tám tiếng (`28800` giây), dạng `08:00:00`, cấu hình bật/tắt.
- Tiêu đề dải đồng hồ trên cả bốn trang: dòng 1 “Đăng Ký Ngay”, dòng 2 in đậm “Nhận Xe Điện Trong Ngày”.
- Cách tính mốc bắt đầu và hành vi hết giờ chưa chốt. Không tự gắn với hạn ưu đãi, không tự reset mỗi lần tải lại trang. Phần demo phải tách khỏi nội dung được phép xuất bản.
- Chia sẻ tài xế: đúng ba ảnh gồm chia sẻ và ảnh thu nhập. Mobile xếp ba ảnh từ trên xuống dưới, không tự chuyển; desktop dùng carousel một ảnh mỗi lượt, tự chuyển sau 7 giây. Bấm ảnh để xem lớn.
- Ảnh và lời chia sẻ trong concept là minh họa. Chỉ xuất bản tên, ảnh, số thu nhập và lời chứng thực thật khi có nội dung được phép sử dụng; không tự tạo đánh giá/số lượng tài xế như bằng chứng thật.
- FAQ đóng/mở được, nội dung đọc được và có cấu trúc HTML phù hợp.
- Footer có thông tin liên hệ được cung cấp, liên kết bảo mật và nguyên văn dòng:

> Trang web được tạo lên bởi đơn vị liên kết tuyển dụng tài xế Xanh SM

## 8. Tiêu chí nghiệm thu giao diện

- Kiểm tra ít nhất ở chiều rộng 360px, 390px và desktop; không tràn ngang.
- Chữ nội dung hướng tới tối thiểu 16px, mục tiêu chạm khoảng 44px; nhãn form luôn nhìn thấy.
- Tất cả CTA, menu, popup và form hoạt động nhất quán trên bốn trang.
- Không để menu/bong bóng che form, CTA hoặc footer.
- Cùng định nghĩa form, không tạo bốn bản độc lập dễ lệch nhau.
- Nội dung trang là HTML/CSS thật; không dùng ảnh concept nguyên trang làm website.

## 9. Trang Taxi — chốt ngày 13/10/2026

- Thứ tự: hero → countdown demo tám giờ → form inline → lợi ích, hỗ trợ và chính sách tham khảo → hướng dẫn chuẩn bị giấy tờ → quy trình → ba ảnh chia sẻ → FAQ → footer.
- Theo yêu cầu mới nhất, bỏ hoàn toàn section “Công việc của bạn / Cùng Taxi điện, đón những hành trình mới”; quyền lợi nằm ngay sau form.
- Chỉ dùng một ảnh tài xế với xe Taxi ở hero: `public/assets/images/hero-section/taxi.webp`, do người dùng cung cấp. Không tạo thêm ảnh nội dung Taxi.
- Hero phải cùng kiểu Bike theo chỉnh sửa mới nhất: ảnh phủ toàn bộ nền hero, lớp phủ sáng để đọc chữ, hai nút “Đăng ký tư vấn” và “Xem quyền lợi” trên ảnh; countdown chồng nhẹ lên mép dưới. Không dùng bố cục chữ và ảnh tách thành hai khối hoặc ảnh bo góc riêng.
- Theo yêu cầu mới nhất, phần chia sẻ dùng đúng ba ảnh hiện có của Bike, cùng nguồn dữ liệu `content/driver-stories.php` và component chung; không thêm lời chứng thực hoặc con số mới.
- Không có ba thẻ hình thức và popup chi tiết riêng của Bike. Nội dung chưa được cung cấp dùng lời tư vấn trung tính, không tự liệt kê hạng bằng lái, hồ sơ bắt buộc, tiền cọc, thu nhập hoặc lịch nhận xe.
- Người dùng đã bổ sung ảnh tham khảo quyền lợi/giấy tờ Taxi: chủ động thời gian, đối soát doanh thu, lương cứng/bảo hiểm, cộng đồng, vận hành điện, hướng dẫn ứng dụng và kỹ thuật; giấy tờ gồm CCCD/hộ chiếu, bằng B/B2 (trao đổi cách dùng trên VNeID), lý lịch tư pháp số 2, giấy khám sức khỏe người lái xe. Dùng nội dung này ở mức tham khảo, có ngữ cảnh theo chương trình/khu vực; không đưa các cam kết miễn phí hoặc hỗ trợ 24/7 thành lời hứa cố định. Dòng nhận xe trong ngày ở dải đồng hồ theo yêu cầu trực tiếp mới nhất.
- Bản chỉnh nội dung mới: quyền lợi Taxi phải nêu rõ cơ chế của hình thức tài xế công ty (xe được bố trí, lương cứng + doanh số/thưởng, hợp đồng và bảo hiểm), cách theo dõi kết quả vận doanh và bước làm quen xe/ứng dụng. Nêu phạm vi “tài xế công ty” ngay tại thẻ tương ứng, không làm người đọc hiểu đây là quyền lợi chung cho mọi hình thức. Quy trình đi từ gửi thông tin đến bắt đầu nhận chuyến; hạn chế các câu chỉ hẹn tư vấn.
- Theo phản hồi mới nhất, phần CCCD và bằng lái đều hiển thị câu “Có thể sử dụng CCCD hoặc BLX trên VNeID.”; bốn bước đăng ký Taxi trở lại nội dung trung tính trước đợt viết chi tiết quy trình vận doanh.
- Tiêu đề popup dùng chung phải là “Đăng ký nhận tư vấn”. Chỉ chọn sẵn phương tiện/hình thức theo ánh xạ cấu hình đã có. Taxi hiện để trống hai lựa chọn này.
- Form inline/modal đồng bộ trong bộ nhớ trang, gồm tùy chọn Zalo cùng số điện thoại; không lưu dữ liệu hồ sơ vào localStorage hoặc URL. Khi backend được cấu hình, form gửi đến endpoint chung và chỉ báo thành công sau khi hồ sơ cùng job thông báo đã được commit.
- Hỗ trợ không có nút x riêng; thu gọn bằng nút Hỗ trợ, tạm ẩn khi vị trí nổi chồng lên form, countdown, CTA hoặc footer. Gọi/Zalo khóa khi thiếu cấu hình thật.

## 10. Trang RTO — chốt ngày 13/10/2026

- Hero dùng bố cục ảnh nền toàn khối và countdown chồng nhẹ theo chuẩn Bike, nhưng dùng nội dung và ảnh riêng của RTO.
- Phần “RTO là gì?” chỉ giải thích ngắn gọn theo mạch thuê xe điện → chạy xe → từng bước sở hữu chính xe đang sử dụng; không nhấn vào hành vi mua xe. Phần này vẫn kèm đối tượng phù hợp và điểm khác biệt, không có mục “Bắt đầu như thế nào?”.
- Bỏ section “Trao đổi trước khi tham gia”. Không lặp lại một section chính sách riêng giữa lợi ích và giấy tờ.
- Section quyền lợi RTO có tiêu đề “Quyền lợi của tài xế” và đúng bốn thẻ theo thứ tự: chạy xe và tiến tới sở hữu chính xe điện đang sử dụng, miễn phí đồng phục và nhận xe điện, hỗ trợ 24/7, hồ sơ nhanh và nhận xe nhanh. Thẻ đầu nhấn mạnh tính sở hữu, không mở đầu bằng nội dung thuê xe; không nêu giá hoặc số tiền trong các thẻ.
- Hạn chế lặp các cụm “lộ trình”, “trao đổi” và “chương trình áp dụng”; ưu tiên câu ngắn, trực tiếp và dễ hiểu.
- Bản chỉnh nội dung mới: giải thích RTO bằng cơ chế thuê xe để vận doanh, khoản thuê/cọc/kỳ hạn, cơ hội mua lại sau thời gian thuê hoặc trước hạn theo chính sách. Trình bày như cấu trúc phương án, không đăng mức tiền cố định hoặc hứa chắc quyền sở hữu. Giấy tờ chỉ liệt kê giấy tờ, không chèn “thông tin muốn thuê” vào danh sách giấy tờ.
- Theo phản hồi mới nhất, giữ phần giấy tờ đã làm rõ; riêng phần giới thiệu, bốn bước đăng ký và FAQ trở lại nội dung trung tính trước đợt viết chi tiết cơ chế thuê/mua lại.
- Khi so sánh các hình thức trên trang RTO, dùng câu “Chạy xe công ty sử dụng xe công ty”; không dùng từ “bố trí”.
- FAQ trên cả bốn trang ưu tiên câu trả lời trực tiếp và chủ động lựa chọn; không dùng “bố trí”, “tư vấn viên”, “được giới thiệu” hoặc “được cung cấp” khi có thể nêu rõ hành động và thông tin ngay tại câu trả lời.

## 11. Nội dung Van — cập nhật ngày 13/10/2026

- Quyền lợi và công việc phải cho thấy tài xế lái EC Van giao nhận hàng nội đô, trạng thái đơn/đối soát qua ứng dụng, đào tạo quy trình và chính sách cho người mới. Nếu nhắc hỗ trợ thu nhập hoặc sạc xe, nêu rõ phạm vi địa bàn/giai đoạn và điều kiện vận doanh, không biến chương trình ngắn hạn thành lời hứa chung.
- Quy trình gồm gửi thông tin, nắm công việc/chính sách, chuẩn bị và làm quen, rồi bắt đầu nhận đơn sau khi hoàn tất thủ tục. Tránh lặp câu “được tư vấn” ở các bước.
- Theo phản hồi mới nhất, thay thẻ chính sách tài xế mới bằng “Cộng đồng và hỗ trợ”; phần CCCD và bằng lái đều hiển thị câu “Có thể sử dụng CCCD hoặc BLX trên VNeID.”; bốn bước đăng ký Van trở lại nội dung trung tính trước đợt viết chi tiết.
