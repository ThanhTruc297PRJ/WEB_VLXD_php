<?php
$current_url = $_GET['url'] ?? '';
$cart_count = getCartCount();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME . ' | Vật Liệu Xây Dựng Uy Tín Giá Tốt'; ?></title>
    <meta name="description" content="Chuyên cung cấp vật liệu xây dựng thô và hoàn thiện: Thép Hòa Phát, Pomina, Xi măng Hà Tiên, Insee, Cát bê tông, Đá 1x2, Gạch tuynel. Vận chuyển tận công trình.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
</head>
<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="container topbar-content">
            <div class="topbar-info">
                <span><i class="fa-solid fa-truck-fast"></i> Giao hàng tận công trình bằng xe ben & xe cẩu</span>
                <span><i class="fa-solid fa-phone"></i> Hotline 24/7: <strong><?php echo SITE_HOTLINE; ?></strong></span>
            </div>
            <div class="topbar-links">
                <a href="<?php echo url('quote'); ?>"><i class="fa-solid fa-file-invoice-dollar"></i> Yêu cầu báo giá công trình</a>
                <?php if (!empty($_SESSION['admin_id'])): ?>
                    <a href="<?php echo url('admin'); ?>"><i class="fa-solid fa-user-shield"></i> Quản trị</a>
                    <a href="<?php echo url('admin/logout'); ?>"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                <?php elseif (!empty($_SESSION['customer_id'])): ?>
                    <a href="<?php echo url('account/profile'); ?>" style="color: #fbbf24;"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['customer_name']); ?></a>
                    <a href="<?php echo url('account/orders'); ?>"><i class="fa-solid fa-clipboard-list"></i> Đơn hàng</a>
                    <a href="<?php echo url('logout'); ?>"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                <?php else: ?>
                    <a href="<?php echo url('login'); ?>"><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</a>
                    <a href="<?php echo url('register'); ?>"><i class="fa-solid fa-user-plus"></i> Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header class="header-main">
        <div class="container header-wrapper">
            <a href="<?php echo url('/'); ?>" class="logo-brand">
                <div class="logo-icon"><i class="fa-solid fa-trowel-bricks"></i></div>
                <div class="logo-text">
                    <h1>VLXD HƯƠNG TIẾN</h1>
                    <p>VẬT TƯ CÔNG TRÌNH & DÂN DỤNG</p>
                </div>
            </a>

            <div class="header-search">
                <form action="<?php echo url('products'); ?>" method="GET" class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Tìm kiếm thép, xi măng, cát, đá, gạch..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                </form>
            </div>

            <div class="header-actions">
                <a href="<?php echo url('cart'); ?>" class="action-item">
                    <div class="action-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="badge-count" id="cart-counter"><?php echo $cart_count; ?></span>
                    </div>
                    <div class="action-text">
                        <span>Giỏ hàng</span>
                        <strong>Vật tư đặt mua</strong>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-wrapper">
            <ul class="nav-links">
                <li class="nav-item <?php echo ($current_url === '') ? 'active' : ''; ?>">
                    <a href="<?php echo url('/'); ?>"><i class="fa-solid fa-house"></i> Trang Chủ</a>
                </li>
                <li class="nav-item <?php echo (str_starts_with($current_url, 'product')) ? 'active' : ''; ?>">
                    <a href="<?php echo url('products'); ?>"><i class="fa-solid fa-boxes-stacked"></i> Danh Mục Vật Liệu</a>
                </li>
                <li class="nav-item <?php echo ($current_url === 'estimate') ? 'active' : ''; ?>">
                    <a href="<?php echo url('estimate'); ?>"><i class="fa-solid fa-calculator"></i> Dự Toán Vật Tư Xây Nhà</a>
                </li>
                <li class="nav-item <?php echo ($current_url === 'quote') ? 'active' : ''; ?>">
                    <a href="<?php echo url('quote'); ?>"><i class="fa-solid fa-file-signature"></i> Báo Giá Công Trình</a>
                </li>
                <li class="nav-item <?php echo ($current_url === 'contact') ? 'active' : ''; ?>">
                    <a href="<?php echo url('contact'); ?>"><i class="fa-solid fa-map-location-dot"></i> Liên Hệ & Kho Bãi</a>
                </li>
            </ul>
            <div>
                <a href="<?php echo url('quote'); ?>" class="nav-special-btn">
                    <i class="fa-solid fa-bolt"></i> Báo Giá Nhanh Số Lượng Lớn
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <?php echo $content; ?>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h3>VLXD HƯƠNG TIẾN</h3>
                <p><?php echo SITE_SLOGAN; ?>. Chuyên cung cấp trọn gói từ phần thô đến phần hoàn thiện với giá xuất xưởng tốt nhất khu vực.</p>
                <p><i class="fa-solid fa-clock"></i> <strong>Giờ xuất hàng kho bãi:</strong> 05:30 - 22:00 (Cả Thứ Bảy & Chủ Nhật)</p>
            </div>
            <div class="footer-col">
                <h3>Vật Tư Trọng Điểm</h3>
                <ul class="footer-links">
                    <li><a href="<?php echo url('products?cat=3'); ?>"><i class="fa-solid fa-angle-right"></i> Thép Xây Dựng Hòa Phát, Pomina</a></li>
                    <li><a href="<?php echo url('products?cat=1'); ?>"><i class="fa-solid fa-angle-right"></i> Xi Măng Hà Tiên, INSEE PCB40</a></li>
                    <li><a href="<?php echo url('products?cat=2'); ?>"><i class="fa-solid fa-angle-right"></i> Cát Vàng Bê Tông & Cát Xây Tô</a></li>
                    <li><a href="<?php echo url('products?cat=2'); ?>"><i class="fa-solid fa-angle-right"></i> Đá Xanh 1x2, Đá 4x6 Hóa An</a></li>
                    <li><a href="<?php echo url('products?cat=4'); ?>"><i class="fa-solid fa-angle-right"></i> Gạch Tuynel 4 Lỗ Bình Dương</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Dịch Vụ & Vận Chuyển</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fa-solid fa-shield-halved"></i> Cam kết đúng tem mác, đủ khối lượng</a></li>
                    <li><a href="#"><i class="fa-solid fa-truck-moving"></i> Đội xe ben 2.5T, 5T & xe cẩu 15T</a></li>
                    <li><a href="#"><i class="fa-solid fa-file-invoice"></i> Cung cấp đầy đủ CO/CQ & Hóa đơn VAT</a></li>
                    <li><a href="<?php echo url('estimate'); ?>"><i class="fa-solid fa-calculator"></i> Hỗ trợ dự toán vật tư miễn phí</a></li>
                    <li><a href="<?php echo url('quote'); ?>"><i class="fa-solid fa-headset"></i> Hợp đồng cung ứng công trình dài hạn</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Kho Bãi & Liên Hệ</h3>
                <p><i class="fa-solid fa-location-dot" style="color: var(--primary);"></i> <?php echo SITE_ADDRESS; ?></p>
                <p><i class="fa-solid fa-warehouse" style="color: var(--primary);"></i> <?php echo SITE_WAREHOUSE; ?></p>
                <p><i class="fa-solid fa-phone" style="color: var(--primary);"></i> Hotline: <strong><?php echo SITE_HOTLINE; ?></strong></p>
                <p><i class="fa-solid fa-envelope" style="color: var(--primary);"></i> Email: <?php echo SITE_EMAIL; ?></p>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Thiết kế theo mô hình MVC trên Laragon.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo asset('js/main.js'); ?>"></script>
</body>
</html>
