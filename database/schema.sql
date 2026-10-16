-- ==============================================================
-- DATABASE: CỬA HÀNG VẬT LIỆU XÂY DỰNG (VLXD)
-- Hỗ trợ import trực tiếp vào MySQL / phpMyAdmin trên Laragon
-- ==============================================================

CREATE DATABASE IF NOT EXISTS `vlxd_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `vlxd_db`;

-- 1. BẢNG DANH MỤC SẢN PHẨM (CATEGORIES)
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `icon` VARCHAR(50) DEFAULT 'fa-cubes',
    `description` TEXT,
    `status` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. BẢNG SẢN PHẨM (PRODUCTS)
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `sku` VARCHAR(50) UNIQUE,
    `unit` VARCHAR(50) NOT NULL COMMENT 'Đơn vị tính: Bao, Tấn, m3, Cây, Viên, Thùng, Kg',
    `price` DECIMAL(15,2) DEFAULT 0,
    `price_negotiable` TINYINT(1) DEFAULT 0 COMMENT '1: Giá liên hệ theo số lượng công trình',
    `specification` VARCHAR(255) DEFAULT NULL COMMENT 'Quy cách kỹ thuật',
    `brand` VARCHAR(100) DEFAULT NULL COMMENT 'Thương hiệu sản xuất',
    `description` TEXT,
    `image` VARCHAR(255) DEFAULT '/assets/images/no-image.svg',
    `stock` INT DEFAULT 100,
    `is_featured` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. BẢNG YÊU CẦU BÁO GIÁ CÔNG TRÌNH (QUOTES)
DROP TABLE IF EXISTS `quotes`;
CREATE TABLE `quotes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fullname` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `project_address` VARCHAR(255) NOT NULL COMMENT 'Địa chỉ công trình nhận hàng',
    `project_type` VARCHAR(100) DEFAULT 'Nhà ở dân dụng' COMMENT 'Loại công trình: Nhà phố, Biệt thự, Dự án lớn, Sửa chữa',
    `material_notes` TEXT NOT NULL COMMENT 'Chi tiết số lượng vật tư cần báo giá (Tấn thép, khối cát, bao xi măng...)',
    `delivery_date` DATE DEFAULT NULL COMMENT 'Ngày dự kiến cần cấp hàng',
    `status` ENUM('Mới tiếp nhận', 'Đang báo giá', 'Đã chốt hợp đồng', 'Đã hủy') DEFAULT 'Mới tiếp nhận',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. BẢNG ĐƠN HÀNG TRỰC TUYẾN (ORDERS)
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_code` VARCHAR(30) UNIQUE NOT NULL,
    `customer_name` VARCHAR(100) NOT NULL,
    `customer_phone` VARCHAR(20) NOT NULL,
    `customer_email` VARCHAR(100) DEFAULT NULL,
    `delivery_address` VARCHAR(255) NOT NULL,
    `vehicle_requirement` VARCHAR(100) DEFAULT 'Xe ben 5 tấn' COMMENT 'Yêu cầu xe vào: Xe ba gác, Xe 2.5T, Xe ben 5T, Xe cẩu 15T',
    `notes` TEXT,
    `total_amount` DECIMAL(15,2) DEFAULT 0,
    `payment_method` VARCHAR(50) DEFAULT 'COD' COMMENT 'COD, Chuyển khoản ngân hàng',
    `order_status` ENUM('Chờ xác nhận', 'Đang bốc xếp & vận chuyển', 'Đã giao tới công trình', 'Đã hủy') DEFAULT 'Chờ xác nhận',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. CHI TIẾT ĐƠN HÀNG (ORDER_ITEMS)
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `product_name` VARCHAR(255) NOT NULL,
    `unit` VARCHAR(50) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `price` DECIMAL(15,2) NOT NULL,
    `subtotal` DECIMAL(15,2) NOT NULL,
    CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. BẢNG HÌNH ẢNH SẢN PHẨM (PRODUCT_IMAGES)
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_product_images_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. BẢNG TÀI KHOẢN KHÁCH HÀNG (CUSTOMERS)
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fullname` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. BẢNG TÀI KHOẢN QUẢN TRỊ (ADMINS)
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `fullname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================================
-- DỮ LIỆU MẪU (SEED DATA)
-- ==============================================================

-- 1. Insert danh mục mẫu
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `description`) VALUES
(1, 'Xi Măng & Vữa', 'xi-mang-vua', 'fa-cubes', 'Xi măng xây tô, xi măng đa dụng, vữa khô trộn sẵn các loại chất lượng cao'),
(2, 'Cát & Đá Xây Dựng', 'cat-da-xay-dung', 'fa-mountain', 'Cát vàng bê tông, cát xây tô, đá 1x2, đá 4x6, đá mi sàng chuẩn sàng lọc'),
(3, 'Sắt Thép Xây Dựng', 'sat-thep-xay-dung', 'fa-layer-group', 'Thép cuộn, thép cây phi 10, 12, 16, 20 từ Hòa Phát, Pomina, Việt Nhật'),
(4, 'Gạch Xây Dựng', 'gach-xay-dung', 'fa-th-large', 'Gạch tuynel 4 lỗ, gạch đinh, gạch block không nung, gạch nhẹ AAC'),
(5, 'Sơn & Chống Thấm', 'son-chong-tham', 'fa-paint-roller', 'Sơn nội ngoại thất cao cấp, sơn lót, chất chống thấm Sika, Kova, Dulux'),
(6, 'Tôn & Xà Gồ Mái', 'ton-xa-go-mai', 'fa-warehouse', 'Tôn lạnh cách nhiệt 3 lớp Hoa Sen, Đông Á, xà gồ thép mạ kẽm C, Z');

-- 2. Insert sản phẩm mẫu
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `unit`, `price`, `price_negotiable`, `specification`, `brand`, `description`, `is_featured`, `stock`) VALUES
(1, 1, 'Xi Măng Hà Tiên Đa Dụng PCB40', 'xi-mang-ha-tien-pcb40', 'XM-HT-40', 'Bao', 89000, 0, '50kg/bao - Chuẩn TCVN 6260:2009', 'Hà Tiên', 'Xi măng Pooc lăng hỗn hợp PCB40 Hà Tiên sử dụng cho hầu hết các hạng mục công trình từ móng, dầm, cột đến xây trát.', 1, 500),
(2, 1, 'Xi Măng INSEE Đa Dụng Easy Clean', 'xi-mang-insee-easy-clean', 'XM-INSEE-01', 'Bao', 94000, 0, '50kg/bao - Công nghệ đột phá', 'INSEE', 'Xi măng thế hệ mới giúp bề mặt vữa xây tô láng mịn, giảm rạn nứt chân chim tối đa.', 1, 350),
(3, 2, 'Cát Vàng Hạt Lớn Đổ Bê Tông', 'cat-vang-do-be-tong', 'CAT-VANG-01', 'm3', 380000, 0, 'Hạt vàng sạch 1.5 - 2.5mm, ít tạp chất', 'Miền Nam', 'Cát vàng khai thác tự nhiên được đãi rửa sạch tạp chất, tối ưu cường độ chịu lực cho kết cấu bê tông.', 1, 200),
(4, 2, 'Đá Xanh 1x2 Đổ Sàn Dầm', 'da-xanh-1x2', 'DA-1X2-XANH', 'm3', 420000, 0, 'Kích cỡ hạt 10x28mm, đá nguyên khai', 'Hóa An', 'Đá xanh Hóa An cường độ nén cao, chuyên dùng trộn bê tông móng cọc, dầm sàn nhà phố và cao tầng.', 1, 150),
(5, 3, 'Thép Cây Vằn D10 Hòa Phát CB300', 'thep-cay-d10-hoa-phat', 'THEP-HP-D10', 'Cây', 128000, 0, 'Chiều dài 11.7m/cây - Chuẩn CB300V', 'Hòa Phát', 'Thép xây dựng Hòa Phát chính hãng, dập nổi logo ba hoa tiêu, độ dẻo dai và chịu uốn tuyệt vời.', 1, 1000),
(6, 3, 'Thép Cây Vằn D16 Pomina CB400', 'thep-cay-d16-pomina', 'THEP-PM-D16', 'Cây', 335000, 0, 'Chiều dài 11.7m/cây - Mác thép CB400', 'Pomina', 'Thép gân Pomina cường độ cao, chuyên dùng cho cột trụ chịu lực chính các công trình kiên cố.', 1, 600),
(7, 4, 'Gạch Tuynel 4 Lỗ Bình Dương', 'gach-tuynel-4-lo-binh-duong', 'GACH-4L-BD', 'Viên', 1250, 0, 'Kích thước 80x80x180mm', 'Bình Dương', 'Gạch nung bằng lò tuynel hiện đại, chín đều, màu đỏ gạch tự nhiên, chịu lực nén cao và chống thấm tốt.', 1, 50000),
(8, 4, 'Gạch Đinh Đặc 2 Lỗ Chống Thấm', 'gach-dinh-dac-2-lo', 'GACH-DINH-01', 'Viên', 1400, 0, 'Kích thước 40x80x180mm', 'Đồng Tâm', 'Dùng xây chân tường chống ẩm, hố ga, bể phốt và các vị trí chịu lực đặc thù.', 0, 20000),
(9, 5, 'Chất Chống Thấm Sika Latex TH (Can 5 Lít)', 'sika-latex-th-5l', 'SIKA-LT-5L', 'Can', 410000, 0, 'Can 5 Lít - Nhũ tương phụ gia polyme', 'Sika Thụy Sĩ', 'Phụ gia cao cấp tăng tính liên kết cho vữa dặm vá, vữa cán sàn và tạo lớp chống thấm tuyệt hảo.', 1, 80),
(10, 5, 'Sơn Ngoại Thất Dulux Weathershield 15L', 'son-ngoai-that-dulux-weathershield-15l', 'SON-DL-WS15', 'Thùng', 2850000, 0, 'Thùng 15 Lít - Màng sơn bóng kháng kiềm', 'Dulux', 'Bảo vệ ngôi nhà bền màu lên đến 8 năm bất chấp thời tiết nhiệt đới khắc nghiệt.', 0, 40),
(11, 6, 'Tôn Lạnh Cách Nhiệt PU 3 Lớp Hoa Sen 0.45mm', 'ton-lanh-pu-hoa-sen-045', 'TON-HS-PU45', 'm2', 175000, 0, 'Khổ rộng 1.07m - Lõi xốp cách nhiệt PU', 'Hoa Sen', 'Khả năng cách âm chống ồn và cách nhiệt chống nóng giảm tới 15 độ C cho không gian bên dưới.', 1, 500),
(12, 3, 'Thép Cuộn Phi 6 Hòa Phát (Bán Theo Tấn)', 'thep-cuon-phi-6-hoa-phat', 'THEP-CUON-P6', 'Tấn', 16500000, 0, 'Cuộn ~ 1.5 đến 2 tấn - Chuẩn TCVN', 'Hòa Phát', 'Thép cuộn trơn phi 6 dùng làm đai cọc, gia cố sàn bê tông.', 1, 50);

-- 3. Insert tài khoản Admin mặc định (admin / 123456)
-- Password '123456' hash theo bcrypt
INSERT INTO `admins` (`id`, `username`, `password`, `fullname`, `email`) VALUES
(1, 'admin', '$2y$10$w8Tlh9P5d28bA3kC2o7iXe9Wn2mQfOaE0Uvj3tCg1zH4uK8yYxK6K', 'Quản Trị Viên Kho VLXD', 'admin@vlxdhaiphong.com');

-- 4. Insert yêu cầu báo giá mẫu
INSERT INTO `quotes` (`id`, `fullname`, `phone`, `email`, `project_address`, `project_type`, `material_notes`, `delivery_date`, `status`) VALUES
(1, 'Kỹ Sư Trần Văn Long', '0912345678', 'longtran.cons@gmail.com', 'Khu Đô Thị Vạn Phúc, TP. Thủ Đức', 'Biệt thự 3 tầng', 'Cần cấp 15 tấn thép Pomina CB400 (D10, D16, D20), 120 bao xi măng INSEE, 35m3 cát bê tông hạt lớn. Yêu cầu giao bằng xe cẩu 10T.', '2026-11-01', 'Mới tiếp nhận'),
(2, 'Anh Nguyễn Hoàng Nam', '0987654321', 'nam.hoang@yahoo.com', 'Đường số 8, P. Linh Xuân, TP. Thủ Đức', 'Nhà phố liền kề', 'Báo giá 40 bao xi măng Hà Tiên PCB40 và 12,000 viên gạch tuynel 4 lỗ giao tới hẻm xe tải 2.5T.', '2026-10-25', 'Đang báo giá');
