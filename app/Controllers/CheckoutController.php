<?php

require_once ROOT_PATH . '/app/Models/Order.php';

class CheckoutController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $this->redirect('cart');
            return;
        }

        $this->view('checkout/index', [
            'page_title'  => 'Đặt Hàng & Giao Nhận Công Trình',
            'cart_items'   => $_SESSION['cart'],
            'cart_total'   => getCartTotal(),
        ]);
    }

    public function process(): void
    {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $this->redirect('cart');
            return;
        }

        $cart_items = $_SESSION['cart'];
        $cart_total = getCartTotal();

        $customer_name    = cleanInput($_POST['customer_name'] ?? '');
        $customer_phone   = cleanInput($_POST['customer_phone'] ?? '');
        $customer_email   = cleanInput($_POST['customer_email'] ?? '');
        $delivery_address = cleanInput($_POST['delivery_address'] ?? '');
        $vehicle_req      = cleanInput($_POST['vehicle_requirement'] ?? 'Xe ben 5 tấn');
        $notes            = cleanInput($_POST['notes'] ?? '');
        $payment_method   = cleanInput($_POST['payment_method'] ?? 'COD');
        $distance_km      = max(0, (float)($_POST['distance_km'] ?? 0));

        if (!isset(SHIPPING_RATES[$vehicle_req])) {
            $vehicle_req = 'Xe ben 5 tấn';
        }

        $shipping_fee = calcShippingFee($vehicle_req, $distance_km);
        $grand_total  = $cart_total + $shipping_fee;
        $notes = trim($notes . ' | Cự ly: ' . $distance_km . 'km, phí vận chuyển: ' . number_format($shipping_fee, 0, ',', '.') . 'đ');

        $order_code = Order::create([
            'customer_name'      => $customer_name,
            'customer_phone'     => $customer_phone,
            'customer_email'     => $customer_email,
            'delivery_address'   => $delivery_address,
            'vehicle_requirement'=> $vehicle_req,
            'notes'              => $notes,
            'total_amount'       => $grand_total,
            'payment_method'     => $payment_method,
        ], $cart_items);

        $order_success = ($order_code !== null);
        if ($order_success) $_SESSION['cart'] = [];

        $this->view('checkout/index', [
            'page_title'     => 'Đặt Hàng & Giao Nhận Công Trình',
            'order_success'  => $order_success,
            'order_code'     => $order_code,
            'order_total'    => $grand_total,
            'order_shipping' => $shipping_fee,
            'order_payment'  => $payment_method,
            'cart_items'     => $cart_items,
            'cart_total'     => $cart_total,
        ]);
    }
}
