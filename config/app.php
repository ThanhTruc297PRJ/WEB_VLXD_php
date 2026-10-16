<?php

// ============================================================
// CẤU HÌNH ỨNG DỤNG - WEBSITE VẬT LIỆU XÂY DỰNG
// ============================================================

// Load thông tin nhạy cảm từ env.php (DB, SMTP)
require_once __DIR__ . '/env.php';

// 1. THÔNG TIN CỬA HÀNG
define('SITE_NAME',      'VẬT LIỆU XÂY DỰNG HƯƠNG TIẾN');
define('SITE_SLOGAN',    'Nhà phân phối sắt thép, xi măng, cát đá & vật liệu hoàn thiện uy tín');
define('SITE_HOTLINE',   '0972.720.731');
define('SITE_EMAIL',     'vlxdhuongtien@gmail.com');
define('SITE_ADDRESS',   'Mỹ Thạnh, Phường Bình Định, Tỉnh Gia Lai');
define('SITE_WAREHOUSE', 'Kho Bãi: Mỹ Thạnh, Phường Bình Định, Tỉnh Gia Lai');
define('BASE_URL',       '');

// 2. THANH TOÁN NGÂN HÀNG (VietQR)
define('BANK_ID',           'MB');
define('BANK_ACCOUNT_NO',   '30029072005');
define('BANK_ACCOUNT_NAME', 'PHAM THANH TRUC');

// 3. BẢNG GIÁ VẬN CHUYỂN
const SHIPPING_RATES = [
    'Xe ba gác trung chuyển' => ['base' => 50000,  'free_km' => 3, 'per_km' => 10000],
    'Xe tải 2.5 tấn'         => ['base' => 150000, 'free_km' => 5, 'per_km' => 15000],
    'Xe ben 5 tấn'           => ['base' => 250000, 'free_km' => 5, 'per_km' => 25000],
    'Xe cẩu 15 tấn'          => ['base' => 600000, 'free_km' => 5, 'per_km' => 40000],
];

// 4. SMTP FROM NAME
define('SMTP_FROM_NAME', SITE_NAME);
