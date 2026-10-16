<?php

require_once ROOT_PATH . '/app/Models/Product.php';

class CartController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $this->view('cart/index', [
            'page_title'  => 'Giỏ Hàng Vật Tư Đặt Mua',
            'cart_items'  => $_SESSION['cart'],
            'cart_total'  => getCartTotal(),
            'flash'       => getFlash(),
        ]);
    }

    public function handle(): void
    {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $action = $_POST['action'] ?? '';

        match ($action) {
            'add'    => $this->add(),
            'update' => $this->update(),
            'remove' => $this->remove(),
            'clear'  => $this->clear(),
            default  => null,
        };

        $this->redirect('cart');
    }

    private function add(): void
    {
        $p_id = (int)$_POST['product_id'];
        $qty = max(1, (int)($_POST['quantity'] ?? 1));
        $product = Product::find($p_id);

        if ($product) {
            if (isset($_SESSION['cart'][$p_id])) {
                $_SESSION['cart'][$p_id]['quantity'] += $qty;
            } else {
                $_SESSION['cart'][$p_id] = [
                    'id'       => $product['id'],
                    'name'     => $product['name'],
                    'unit'     => $product['unit'],
                    'price'    => $product['price'],
                    'image'    => $product['image'],
                    'quantity' => $qty,
                ];
            }
            setFlash('success', 'Đã thêm vật tư vào giỏ hàng thành công!');
        }
    }

    private function update(): void
    {
        if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $id => $qty) {
                $id = (int)$id;
                $qty = (int)$qty;
                if ($qty <= 0) {
                    unset($_SESSION['cart'][$id]);
                } elseif (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] = $qty;
                }
            }
            setFlash('success', 'Đã cập nhật số lượng vật tư!');
        }
    }

    private function remove(): void
    {
        $remove_id = (int)($_POST['product_id'] ?? 0);
        if (isset($_SESSION['cart'][$remove_id])) {
            unset($_SESSION['cart'][$remove_id]);
            setFlash('info', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }
    }

    private function clear(): void
    {
        $_SESSION['cart'] = [];
        setFlash('info', 'Đã làm trống giỏ hàng.');
    }
}
