<?php

require_once ROOT_PATH . '/app/Models/Product.php';
require_once ROOT_PATH . '/app/Models/Order.php';
require_once ROOT_PATH . '/app/Models/Quote.php';
require_once ROOT_PATH . '/app/Models/Customer.php';
require_once ROOT_PATH . '/app/Models/Category.php';

class DashboardController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $productsByCategory = [];
        $topProducts = [];
        $quotesByStatus = [];
        $recentCustomers = [];

        if ($pdo) {
            try {
                $stmt = $pdo->query(
                    "SELECT c.name, COUNT(p.id) AS cnt
                     FROM categories c LEFT JOIN products p ON c.id = p.category_id
                     GROUP BY c.id, c.name ORDER BY cnt DESC"
                );
                $productsByCategory = $stmt->fetchAll();
            } catch (Exception $e) {}

            try {
                $stmt = $pdo->query(
                    "SELECT p.name, COALESCE(SUM(oi.quantity), 0) AS sold
                     FROM products p
                     LEFT JOIN order_items oi ON p.id = oi.product_id
                     GROUP BY p.id, p.name ORDER BY sold DESC LIMIT 5"
                );
                $topProducts = $stmt->fetchAll();
            } catch (Exception $e) {}

            try {
                $stmt = $pdo->query("SELECT status, COUNT(*) AS cnt FROM quotes GROUP BY status");
                $quotesByStatus = $stmt->fetchAll();
            } catch (Exception $e) {}

            try {
                $stmt = $pdo->query("SELECT fullname, email, phone, created_at FROM customers ORDER BY id DESC LIMIT 5");
                $recentCustomers = $stmt->fetchAll();
            } catch (Exception $e) {}
        }

        $this->view('admin/dashboard', [
            'page_title'         => 'Bảng Điều Khiển Tổng Quan',
            'total_products'     => Product::count(),
            'total_orders'       => Order::count(),
            'total_quotes'       => Quote::count(),
            'total_customers'    => Customer::count(),
            'total_revenue'      => Order::totalRevenue(),
            'revenue_by_month'   => Order::revenueByMonth(6),
            'orders_by_status'   => Order::countByStatus(),
            'products_by_cat'    => $productsByCategory,
            'top_products'       => $topProducts,
            'quotes_by_status'   => $quotesByStatus,
            'recent_orders'      => Order::recent(5),
            'recent_quotes'      => Quote::recent(5),
            'recent_customers'   => $recentCustomers,
        ], 'admin');
    }
}
