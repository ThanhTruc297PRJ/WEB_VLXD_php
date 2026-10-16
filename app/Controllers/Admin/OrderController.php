<?php

require_once ROOT_PATH . '/app/Models/Order.php';
require_once ROOT_PATH . '/app/Models/OrderItem.php';

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

            $stmt = $pdo->prepare("SELECT * FROM orders WHERE $where ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);
            foreach ($params as $i => $v) {
                $stmt->bindValue($i + 1, $v);
            }
            $stmt->execute();
            $orders = $stmt->fetchAll();

            if (!empty($orders)) {
                $ids = array_column($orders, 'id');
                $orderItems = OrderItem::findByOrderIds($ids);
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
            $order = Order::find($orderId);
            $oldStatus = $order['order_status'] ?? '';

            if ($order && $oldStatus !== $newStatus) {
                Order::updateStatus($orderId, $newStatus);
                $this->sendStatusEmail($order, $newStatus);
            }
        }

        $query = $_GET['redirect'] ?? '';
        header('Location: ' . url('admin/orders' . ($query ? '?' . $query : '')));
        exit;
    }

    private function sendStatusEmail(array $order, string $newStatus): void
    {
        $email = $order['customer_email'] ?? '';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) return;

        $statusIcons = [
            'Chờ xác nhận' => '&#9200;',
            'Đang bốc xếp & vận chuyển' => '&#128666;',
            'Đã giao tới công trình' => '&#9989;',
            'Đã hủy' => '&#10060;',
        ];
        $statusColors = [
            'Chờ xác nhận' => '#f59e0b',
            'Đang bốc xếp & vận chuyển' => '#3b82f6',
            'Đã giao tới công trình' => '#10b981',
            'Đã hủy' => '#ef4444',
        ];

        $icon = $statusIcons[$newStatus] ?? '&#128230;';
        $color = $statusColors[$newStatus] ?? '#64748b';
        $name = htmlspecialchars($order['customer_name']);
        $code = htmlspecialchars($order['order_code']);
        $total = number_format($order['total_amount'], 0, ',', '.');
        $siteName = SITE_NAME;
        $hotline = SITE_HOTLINE;

        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SMTP_USERNAME, SMTP_FROM_NAME);
            $mail->addAddress($email, $order['customer_name']);

            $mail->isHTML(true);
            $mail->Subject = "[$siteName] Đơn hàng $code - " . $newStatus;
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 520px; margin: 0 auto; padding: 30px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <div style='width: 56px; height: 56px; background: linear-gradient(135deg, #f36f21, #e85d04); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center;'>
                        <span style='font-size: 24px; color: #fff;'>&#x1F3D7;</span>
                    </div>
                    <h2 style='color: #0f172a; margin: 12px 0 4px;'>Cập Nhật Đơn Hàng</h2>
                    <p style='color: #64748b; font-size: 14px;'>$siteName</p>
                </div>
                <p style='color: #334155; font-size: 15px;'>Xin chào <strong>$name</strong>,</p>
                <p style='color: #334155; font-size: 15px;'>Đơn hàng <strong style=\"color: #f36f21;\">$code</strong> của bạn đã được cập nhật trạng thái:</p>
                <div style='text-align: center; margin: 24px 0;'>
                    <span style='display: inline-block; background: #f8fafc; border: 2px solid $color; border-radius: 10px; padding: 14px 28px; font-size: 18px; font-weight: 700; color: $color;'>
                        $icon " . htmlspecialchars($newStatus) . "
                    </span>
                </div>
                <div style='background: #f8fafc; border-radius: 8px; padding: 16px; margin: 16px 0;'>
                    <table style='width: 100%; font-size: 14px; color: #334155;'>
                        <tr><td style='padding: 4px 0; color: #64748b;'>Mã đơn:</td><td style='text-align: right; font-weight: 700;'>$code</td></tr>
                        <tr><td style='padding: 4px 0; color: #64748b;'>Tổng tiền:</td><td style='text-align: right; font-weight: 700; color: #e11d48;'>{$total}đ</td></tr>
                        <tr><td style='padding: 4px 0; color: #64748b;'>Địa chỉ:</td><td style='text-align: right;'>" . htmlspecialchars($order['delivery_address']) . "</td></tr>
                    </table>
                </div>
                <p style='color: #64748b; font-size: 13px; text-align: center;'>Nếu cần hỗ trợ, vui lòng gọi <strong>$hotline</strong></p>
                <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;'>
                <p style='color: #94a3b8; font-size: 12px; text-align: center;'>Email tự động từ $siteName. Vui lòng không trả lời email này.</p>
            </div>";

            $mail->send();
        } catch (Exception $e) {
            // Không block flow nếu gửi email lỗi
        }
    }
}
