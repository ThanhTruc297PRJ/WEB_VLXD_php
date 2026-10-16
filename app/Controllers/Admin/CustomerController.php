<?php

require_once ROOT_PATH . '/app/Models/Customer.php';

class CustomerController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $search = trim($_GET['search'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;

        $customers = [];
        $totalRows = 0;
        $totalPages = 1;

        if ($pdo) {
            try {
                $where = "1=1";
                $params = [];
                if ($search !== '') {
                    $where .= " AND (fullname LIKE ? OR phone LIKE ? OR email LIKE ?)";
                    $like = "%$search%";
                    $params = [$like, $like, $like];
                }

                $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE $where");
                $stmt->execute($params);
                $totalRows = (int)$stmt->fetchColumn();
                $totalPages = max(1, ceil($totalRows / $perPage));
                $page = min($page, $totalPages);
                $offset = ($page - 1) * $perPage;

                $stmt = $pdo->prepare("
                    SELECT c.*,
                        (SELECT COUNT(*) FROM orders o WHERE o.customer_email = c.email) AS total_orders,
                        (SELECT COALESCE(SUM(o.total_amount),0) FROM orders o WHERE o.customer_email = c.email) AS total_spent
                    FROM customers c
                    WHERE $where
                    ORDER BY c.created_at DESC
                    LIMIT $perPage OFFSET $offset
                ");
                $stmt->execute($params);
                $customers = $stmt->fetchAll();
            } catch (Exception $e) {}
        }

        $this->view('admin/customers', [
            'page_title'  => 'Quản Lý Khách Hàng',
            'customers'   => $customers,
            'search'      => $search,
            'page'        => $page,
            'total_pages' => $totalPages,
            'total_rows'  => $totalRows,
        ], 'admin');
    }

    public function detail(): void
    {
        if (!$this->requireAdmin()) return;

        $id = (int)($_GET['id'] ?? 0);
        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $customer = null;
        $orders = [];
        $orderItems = [];

        if ($pdo && $id > 0) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
                $stmt->execute([$id]);
                $customer = $stmt->fetch();

                if ($customer) {
                    $stmt = $pdo->prepare("SELECT * FROM orders WHERE customer_email = ? ORDER BY created_at DESC");
                    $stmt->execute([$customer['email']]);
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
                }
            } catch (Exception $e) {}
        }

        if (!$customer) {
            header('Location: ' . url('admin/customers'));
            exit;
        }

        $totalSpent = 0;
        foreach ($orders as $o) {
            $totalSpent += $o['total_amount'];
        }

        $this->view('admin/customer_detail', [
            'page_title'  => 'Chi Tiết Khách Hàng',
            'customer'    => $customer,
            'orders'      => $orders,
            'order_items' => $orderItems,
            'total_spent' => $totalSpent,
        ], 'admin');
    }
}
