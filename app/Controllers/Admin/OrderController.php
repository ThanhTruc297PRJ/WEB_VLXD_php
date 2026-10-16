<?php

require_once ROOT_PATH . '/app/Models/Order.php';

class OrderController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $statusFilter = $_GET['status'] ?? '';
        $search = trim($_GET['search'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;

        $orders = [];
        $orderItems = [];
        $totalRows = 0;
        $statusCounts = [];

        if (!$pdo) {
            $this->view('admin/orders', [
                'page_title' => 'Quản Lý Đơn Hàng',
                'orders' => [], 'order_items' => [], 'status_filter' => '',
                'search' => '', 'page' => 1, 'total_pages' => 1, 'total_rows' => 0,
                'status_counts' => [],
            ], 'admin');
            return;
        }

        try {
            $stmtC = $pdo->query("SELECT order_status, COUNT(*) AS cnt FROM orders GROUP BY order_status");
            $statusCounts = $stmtC->fetchAll(PDO::FETCH_KEY_PAIR);

            $where = "1=1";
            $params = [];

            if ($statusFilter !== '') {
                $where .= " AND order_status = ?";
                $params[] = $statusFilter;
            }
            if ($search !== '') {
                $where .= " AND (order_code LIKE ? OR customer_name LIKE ? OR customer_phone LIKE ?)";
                $like = "%$search%";
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
            }

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE $where");
            $stmt->execute($params);
            $totalRows = (int)$stmt->fetchColumn();
            $totalPages = max(1, ceil($totalRows / $perPage));
            $page = min($page, $totalPages);
            $offset = ($page - 1) * $perPage;

            $stmt = $pdo->prepare("SELECT * FROM orders WHERE $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
            $stmt->execute($params);
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

        $this->view('admin/orders', [
            'page_title'    => 'Quản Lý Đơn Hàng',
            'orders'        => $orders,
            'order_items'   => $orderItems,
            'status_filter' => $statusFilter,
            'search'        => $search,
            'page'          => $page,
            'total_pages'   => $totalPages ?? 1,
            'total_rows'    => $totalRows,
            'status_counts' => $statusCounts,
        ], 'admin');
    }

    public function updateStatus(): void
    {
        if (!$this->requireAdmin()) return;

        $orderId = (int)($_POST['order_id'] ?? 0);
        $newStatus = $_POST['new_status'] ?? '';

        $validStatuses = ['Chờ xác nhận', 'Đang bốc xếp & vận chuyển', 'Đã giao tới công trình', 'Đã hủy'];

        if ($orderId > 0 && in_array($newStatus, $validStatuses)) {
            $db = Database::getInstance();
            if ($db->isConnected()) {
                try {
                    $stmt = $db->getConnection()->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
                    $stmt->execute([$newStatus, $orderId]);
                } catch (Exception $e) {}
            }
        }

        $query = $_GET['redirect'] ?? '';
        header('Location: ' . url('admin/orders' . ($query ? '?' . $query : '')));
        exit;
    }
}
