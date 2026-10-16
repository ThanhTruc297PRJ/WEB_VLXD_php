<?php

require_once ROOT_PATH . '/app/Models/Customer.php';

class AccountController extends Controller
{
    private function requireCustomer(): bool
    {
        if (empty($_SESSION['customer_id'])) {
            $this->redirect('login');
            return false;
        }
        return true;
    }

    public function orders(): void
    {
        if (!$this->requireCustomer()) return;

        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $orders = [];
        $orderItems = [];

        if ($pdo) {
            try {
                $email = $_SESSION['customer_email'];
                $stmt = $pdo->prepare("SELECT * FROM orders WHERE customer_email = ? ORDER BY created_at DESC");
                $stmt->execute([$email]);
                $orders = $stmt->fetchAll();

                if (!empty($orders)) {
                    $ids = array_column($orders, 'id');
                    $ph = implode(',', array_fill(0, count($ids), '?'));
                    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id IN ($ph) ORDER BY order_id, id");
                    $stmt->execute($ids);
                    foreach ($stmt->fetchAll() as $item) {
                        $orderItems[$item['order_id']][] = $item;
                    }
                }
            } catch (Exception $e) {}
        }

        $this->view('account/orders', [
            'page_title'  => 'Đơn Hàng Của Tôi',
            'orders'      => $orders,
            'order_items' => $orderItems,
        ]);
    }

    public function profile(): void
    {
        if (!$this->requireCustomer()) return;

        $customer = Customer::find($_SESSION['customer_id']);
        if (!$customer) {
            $this->redirect('login');
            return;
        }

        $this->view('account/profile', [
            'page_title' => 'Hồ Sơ Tài Khoản',
            'customer'   => $customer,
            'success'    => $_GET['success'] ?? '',
            'error'      => $_GET['error'] ?? '',
        ]);
    }

    public function updateProfile(): void
    {
        if (!$this->requireCustomer()) return;

        $id = $_SESSION['customer_id'];
        $fullname = trim($_POST['fullname'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $address  = trim($_POST['address'] ?? '');

        if (empty($fullname) || empty($phone)) {
            header('Location: ' . url('account/profile?error=empty'));
            exit;
        }

        Customer::update($id, [
            'fullname' => $fullname,
            'phone'    => $phone,
            'address'  => $address,
        ]);

        $_SESSION['customer_name'] = $fullname;

        header('Location: ' . url('account/profile?success=profile'));
        exit;
    }

    public function changePassword(): void
    {
        if (!$this->requireCustomer()) return;

        $id = $_SESSION['customer_id'];
        $current  = $_POST['current_password'] ?? '';
        $newPass  = $_POST['new_password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        $customer = Customer::find($id);
        if (!$customer || !password_verify($current, $customer['password'])) {
            header('Location: ' . url('account/profile?error=wrong_password'));
            exit;
        }

        if (strlen($newPass) < 6) {
            header('Location: ' . url('account/profile?error=short_password'));
            exit;
        }

        if ($newPass !== $confirm) {
            header('Location: ' . url('account/profile?error=mismatch'));
            exit;
        }

        Customer::update($id, [
            'password' => password_hash($newPass, PASSWORD_BCRYPT),
        ]);

        header('Location: ' . url('account/profile?success=password'));
        exit;
    }
}
