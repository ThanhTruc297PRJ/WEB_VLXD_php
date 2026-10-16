<?php

require_once ROOT_PATH . '/app/Models/Order.php';
require_once ROOT_PATH . '/app/Models/Product.php';

class RevenueController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $filter  = $_GET['filter'] ?? 'month';
        $year    = (int)($_GET['year'] ?? date('Y'));
        $month   = (int)($_GET['month'] ?? date('m'));
        $quarter = (int)($_GET['quarter'] ?? ceil(date('m') / 3));

        $revenueData = [];
        $ordersList  = [];
        $topProducts = [];
        $summaryByPayment = [];
        $summaryByVehicle = [];
        $orderItems = [];
        $totalRevenue = 0;
        $totalOrders  = 0;
        $avgOrderValue = 0;
        $completedOrders = 0;
        $cancelledOrders = 0;

        if (!$pdo) {
            $this->view('admin/revenue', $this->buildViewData($filter, $year, $month, $quarter, $revenueData, $ordersList, $topProducts, $summaryByPayment, $summaryByVehicle, $orderItems, $totalRevenue, $totalOrders, $avgOrderValue, $completedOrders, $cancelledOrders), 'admin');
            return;
        }

        try {
            $dates = $this->getDateRange($filter, $year, $month, $quarter);
            $dateFrom = $dates[0] . ' 00:00:00';
            $dateTo   = $dates[1] . ' 23:59:59';

            // Revenue chart data
            if ($filter === 'month') {
                $stmt = $pdo->prepare("SELECT DAY(created_at) AS label, COUNT(*) AS total_orders, COALESCE(SUM(total_amount),0) AS revenue FROM orders WHERE created_at BETWEEN ? AND ? GROUP BY label ORDER BY label");
            } else {
                $stmt = $pdo->prepare("SELECT DATE_FORMAT(created_at,'%m/%Y') AS label, COUNT(*) AS total_orders, COALESCE(SUM(total_amount),0) AS revenue FROM orders WHERE created_at BETWEEN ? AND ? GROUP BY label ORDER BY MIN(created_at)");
            }
            $stmt->execute([$dateFrom, $dateTo]);
            $revenueData = $stmt->fetchAll();

            // Orders list
            $stmt = $pdo->prepare("SELECT * FROM orders WHERE created_at BETWEEN ? AND ? ORDER BY created_at DESC");
            $stmt->execute([$dateFrom, $dateTo]);
            $ordersList = $stmt->fetchAll();

            // Order items grouped by order_id
            if (!empty($ordersList)) {
                $orderIds = array_column($ordersList, 'id');
                $placeholders = implode(',', array_fill(0, count($orderIds), '?'));
                $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id IN ($placeholders) ORDER BY order_id, id");
                $stmt->execute($orderIds);
                $allItems = $stmt->fetchAll();
                foreach ($allItems as $item) {
                    $orderItems[$item['order_id']][] = $item;
                }
            }

            $totalRevenue  = array_sum(array_column($revenueData, 'revenue'));
            $totalOrders   = array_sum(array_column($revenueData, 'total_orders'));
            $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            foreach ($ordersList as $o) {
                if (mb_strpos($o['order_status'], 'giao') !== false) $completedOrders++;
                if (mb_strpos($o['order_status'], 'hủy') !== false) $cancelledOrders++;
            }

            // Top products
            $stmt = $pdo->prepare("SELECT oi.product_name, SUM(oi.quantity) AS total_qty, SUM(oi.subtotal) AS total_amount, oi.unit FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE o.created_at BETWEEN ? AND ? GROUP BY oi.product_id, oi.product_name, oi.unit ORDER BY total_amount DESC LIMIT 10");
            $stmt->execute([$dateFrom, $dateTo]);
            $topProducts = $stmt->fetchAll();

            // Payment summary
            $stmt = $pdo->prepare("SELECT payment_method, COUNT(*) AS cnt, COALESCE(SUM(total_amount),0) AS total FROM orders WHERE created_at BETWEEN ? AND ? GROUP BY payment_method");
            $stmt->execute([$dateFrom, $dateTo]);
            $summaryByPayment = $stmt->fetchAll();

            // Vehicle summary
            $stmt = $pdo->prepare("SELECT vehicle_requirement, COUNT(*) AS cnt FROM orders WHERE created_at BETWEEN ? AND ? GROUP BY vehicle_requirement ORDER BY cnt DESC");
            $stmt->execute([$dateFrom, $dateTo]);
            $summaryByVehicle = $stmt->fetchAll();

        } catch (Exception $e) {}

        $this->view('admin/revenue', $this->buildViewData($filter, $year, $month, $quarter, $revenueData, $ordersList, $topProducts, $summaryByPayment, $summaryByVehicle, $orderItems, $totalRevenue, $totalOrders, $avgOrderValue, $completedOrders, $cancelledOrders), 'admin');
    }

    private function getDateRange(string $filter, int $year, int $month, int $quarter): array
    {
        if ($filter === 'month') {
            $from = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
            return [$from, date('Y-m-t', strtotime($from))];
        }
        if ($filter === 'quarter') {
            $sm = ($quarter - 1) * 3 + 1;
            $em = $quarter * 3;
            return ["$year-" . str_pad($sm, 2, '0', STR_PAD_LEFT) . "-01", date('Y-m-t', strtotime("$year-" . str_pad($em, 2, '0', STR_PAD_LEFT) . "-01"))];
        }
        return ["$year-01-01", "$year-12-31"];
    }

    private function buildViewData($filter, $year, $month, $quarter, $revenueData, $ordersList, $topProducts, $summaryByPayment, $summaryByVehicle, $orderItems, $totalRevenue, $totalOrders, $avgOrderValue, $completedOrders, $cancelledOrders): array
    {
        return [
            'page_title'       => 'Báo Cáo Doanh Thu',
            'filter'           => $filter,
            'year'             => $year,
            'month'            => $month,
            'quarter'          => $quarter,
            'revenue_data'     => $revenueData,
            'orders_list'      => $ordersList,
            'top_products'     => $topProducts,
            'summary_payment'  => $summaryByPayment,
            'summary_vehicle'  => $summaryByVehicle,
            'order_items'      => $orderItems,
            'total_revenue'    => $totalRevenue,
            'total_orders'     => $totalOrders,
            'avg_order_value'  => $avgOrderValue,
            'completed_orders' => $completedOrders,
            'cancelled_orders' => $cancelledOrders,
        ];
    }
}
