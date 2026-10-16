<?php

function formatCurrency($amount, $is_negotiable = 0)
{
    if ($is_negotiable == 1 || $amount <= 0) {
        return '<span class="price-contact">Liên hệ báo giá</span>';
    }
    return number_format($amount, 0, ',', '.') . ' <span class="currency-symbol">đ</span>';
}

function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function setFlash($type, $message)
{
    $_SESSION['flash'] = [
        'type'    => $type,
        'message' => $message,
    ];
}

function getFlash()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function getCartCount()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return 0;
    }
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['quantity'];
    }
    return $total;
}

function getCartTotal()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return 0;
    }
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

function calcShippingFee($vehicle, $km)
{
    $km = max(0, (float)$km);
    $rate = SHIPPING_RATES[$vehicle] ?? SHIPPING_RATES['Xe ben 5 tấn'];
    $extra_km = max(0, ceil($km) - $rate['free_km']);
    return $rate['base'] + $extra_km * $rate['per_km'];
}

function buildVietQRUrl($amount, $content)
{
    return 'https://img.vietqr.io/image/' . rawurlencode(BANK_ID) . '-' . rawurlencode(BANK_ACCOUNT_NO)
        . '-compact2.png?amount=' . (int)$amount
        . '&addInfo=' . rawurlencode($content)
        . '&accountName=' . rawurlencode(BANK_ACCOUNT_NAME);
}

function url($path = '')
{
    $base = rtrim(BASE_URL, '/');
    return $base . '/' . ltrim($path, '/');
}

function asset($path)
{
    $base = rtrim(BASE_URL, '/');
    return $base . '/assets/' . ltrim($path, '/');
}
