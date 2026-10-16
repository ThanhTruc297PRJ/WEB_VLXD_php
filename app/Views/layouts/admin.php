<?php
require_once ROOT_PATH . '/app/Models/Quote.php';
$total_quotes = Quote::count();
$db_connected = Database::getInstance()->isConnected();
$current_url = $_GET['url'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin'; ?> - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo asset('css/admin.css'); ?>">
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-trowel-bricks" style="color: var(--primary); font-size: 24px;"></i>
            <h2>ADMIN VLXD</h2>
        </div>
        <ul class="sidebar-menu">
            <li class="<?php echo ($current_url === 'admin') ? 'active' : ''; ?>">
                <a href="<?php echo url('admin'); ?>"><i class="fa-solid fa-chart-pie"></i> Bảng Thống Kê</a>
            </li>
            <li class="<?php echo ($current_url === 'admin/products') ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/products'); ?>"><i class="fa-solid fa-boxes-stacked"></i> Quản Lý Sản Phẩm</a>
            </li>
            <li class="<?php echo ($current_url === 'admin/orders') ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/orders'); ?>"><i class="fa-solid fa-clipboard-list"></i> Quản Lý Đơn Hàng</a>
            </li>
            <li class="<?php echo (strpos($current_url, 'admin/customers') === 0) ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/customers'); ?>"><i class="fa-solid fa-users"></i> Quản Lý Khách Hàng</a>
            </li>
            <li class="<?php echo ($current_url === 'admin/revenue') ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/revenue'); ?>"><i class="fa-solid fa-chart-line"></i> Báo Cáo Doanh Thu</a>
            </li>
            <li class="<?php echo (strpos($current_url, 'admin/categories') === 0) ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/categories'); ?>"><i class="fa-solid fa-layer-group"></i> Quản Lý Danh Mục</a>
            </li>
            <li class="<?php echo ($current_url === 'admin/quotes') ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/quotes'); ?>"><i class="fa-solid fa-file-invoice-dollar"></i> Yêu Cầu Báo Giá (<?php echo $total_quotes; ?>)</a>
            </li>
            <li class="<?php echo (strpos($current_url, 'admin/contacts') === 0) ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/contacts'); ?>"><i class="fa-solid fa-envelope"></i> Liên Hệ</a>
            </li>
            <li class="<?php echo (strpos($current_url, 'admin/settings') === 0) ? 'active' : ''; ?>">
                <a href="<?php echo url('admin/settings'); ?>"><i class="fa-solid fa-gear"></i> Cài Đặt</a>
            </li>
            <li>
                <a href="<?php echo url('/'); ?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Xem Website Ngoài</a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <p><i class="fa-solid fa-user-shield"></i> <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></p>
            <a href="<?php echo url('admin/logout'); ?>" style="color: #f87171; font-size: 0.82rem; text-decoration: none;">
                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
            </a>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="admin-main">
        <?php echo $content; ?>
    </div>

</body>
</html>
