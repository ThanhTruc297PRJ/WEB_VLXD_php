# HƯỚNG DẪN CÀI ĐẶT DỰ ÁN WEBSITE VẬT LIỆU XÂY DỰNG (VLXD)

Dự án được xây dựng bằng **PHP & MySQL**, thiết kế tối ưu để chạy trên môi trường **Laragon**.

---

## 1. Cấu Trúc Thư Mục Dự Án

```
WEBSITE_VLXD/
├── config/
│   └── database.php         # Kết nối CSDL MySQL qua PDO, cấu hình thông tin cửa hàng
├── database/
│   └── schema.sql           # File tạo CSDL và dữ liệu mẫu (Sắt thép, Xi măng, Cát đá,...)
├── includes/
│   ├── header.php           # Thẻ meta SEO, CSS, Topbar liên hệ & hotline
│   ├── navbar.php           # Thanh menu điều hướng chính
│   ├── footer.php           # Chân trang, chính sách bảo hành & vận chuyển xe cẩu/xe ben
│   └── functions.php        # Các hàm tiện ích: format tiền tệ, slug, thông báo
├── assets/
│   ├── css/
│   │   ├── style.css        # Giao diện hiện đại tông màu công trình (Cam + Xanh than)
│   │   └── admin.css        # Giao diện trang quản trị
│   └── js/
│       └── main.js          # Script giỏ hàng, bộ lọc và công cụ dự toán vật tư
├── admin/
│   ├── index.php            # Bảng điều khiển (Dashboard) thống kê
│   ├── products.php         # Quản lý danh mục & sản phẩm VLXD
│   ├── categories.php       # Quản lý danh mục VLXD
│   └── quotes.php           # Quản lý đơn hàng & yêu cầu báo giá công trình
├── index.php                # Trang chủ (Banner, danh mục nổi bật, sản phẩm, bảng giá)
├── products.php             # Danh sách tất cả sản phẩm VLXD + Bộ lọc theo danh mục
├── product-detail.php       # Chi tiết sản phẩm, quy cách, thông số, nút đặt hàng & báo giá
├── cart.php                 # Quản lý giỏ hàng vật tư
├── checkout.php             # Đặt hàng & nhập thông tin công trình cần giao
├── quote.php                # Gửi yêu cầu nhận bảng báo giá khối lượng lớn
├── estimate.php             # CÔNG CỤ DỰ TOÁN: Tính khối lượng cát, đá, xi măng, thép theo m²
└── contact.php              # Trang liên hệ, bản đồ kho bãi & hotline
```

---

## 2. Hướng Dẫn Cài Đặt Trên Laragon

### Bước 1: Khởi động Laragon
1. Mở phần mềm **Laragon**.
2. Nhấn nút **Start All** để khởi động Apache và MySQL.

### Bước 2: Tạo Cơ Sở Dữ Liệu
1. Mở **phpMyAdmin** (hoặc HeidiSQL trong Laragon) qua đường dẫn: `http://localhost/phpmyadmin`
2. Tạo một Database mới tên là: `vlxd_db` với bảng mã `utf8mb4_unicode_ci`.
3. Chọn tab **Import** (Nhập) và chọn file:
   `database/schema.sql` trong thư mục dự án để nhập dữ liệu mẫu.

### Bước 3: Cấu hình kết nối (Nếu cần)
File `config/database.php` mặc định đã cấu hình sẵn cho Laragon:
- **Host**: `localhost`
- **Database**: `vlxd_db`
- **User**: `root`
- **Password**: ` ` (để trống)

### Bước 4: Chạy Website
- Nếu đặt thư mục dự án trong `C:/laragon/www/WEBSITE_VLXD`:
  Truy cập: `http://localhost/WEBSITE_VLXD` hoặc `http://website_vlxd.test`
- Đăng nhập trang quản trị Admin:
  Đường dẫn: `http://localhost/WEBSITE_VLXD/admin`
  Tài khoản mặc định:
  - **Tên đăng nhập**: `admin`
  - **Mật khẩu**: `123456`

---

## 3. Các Tính Năng Đặc Thù Của Ngành VLXD Đã Tích Hợp
1. **Đơn vị tính đa dạng**: Hỗ trợ đầy đủ bao, tấn, m³ (khối), cây, viên, kg, thùng.
2. **Công cụ dự toán vật tư xây nhà (estimate.php)**: Tự động tính toán số lượng xi măng, cát, đá 1x2, sắt thép, gạch ống cần mua dựa trên diện tích sàn và số tầng.
3. **Chức năng báo giá theo công trình (quote.php)**: Khách hàng dự án / nhà thầu có thể nhập khối lượng cần cung cấp để cửa hàng liên hệ báo giá vận chuyển tận chân công trình.
4. **Bảng báo giá cập nhật hôm nay**: Hiển thị giá thị trường biến động cho sắt thép, cát đá, xi măng.
