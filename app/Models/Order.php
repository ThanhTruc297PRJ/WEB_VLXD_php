<?php

class Order
{
    public static function create(array $data, array $cartItems): ?string
    {
        $db = Database::getInstance();
        $orderCode = 'VLXD-' . date('Ymd') . '-' . rand(1000, 9999);

        if ($db->isConnected()) {
            $pdo = $db->getConnection();
            $pdo->beginTransaction();
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO orders (order_code, customer_name, customer_phone, customer_email,
                     delivery_address, vehicle_requirement, notes, total_amount, payment_method, order_status)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Chờ xác nhận')"
                );
                $stmt->execute([
                    $orderCode, $data['customer_name'], $data['customer_phone'],
                    $data['customer_email'], $data['delivery_address'],
                    $data['vehicle_requirement'], $data['notes'],
                    $data['total_amount'], $data['payment_method'],
                ]);
                $orderId = $pdo->lastInsertId();

                $itemStmt = $pdo->prepare(
                    "INSERT INTO order_items (order_id, product_id, product_name, unit, quantity, price, subtotal)
                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                foreach ($cartItems as $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $itemStmt->execute([
                        $orderId, $item['id'], $item['name'], $item['unit'],
                        $item['quantity'], $item['price'], $subtotal,
                    ]);
                }

                $pdo->commit();
                return $orderCode;
            } catch (Exception $e) {
                if ($pdo->inTransaction()) $pdo->rollBack();
                return null;
            }
        }

        return $orderCode;
    }

    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return null;

        $stmt = $db->getConnection()->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function updateStatus(int $id, string $status): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $stmt = $db->getConnection()->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public static function count(): int
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                return (int)$db->getConnection()->query("SELECT COUNT(*) FROM orders")->fetchColumn();
            } catch (Exception $e) {}
        }
        return 0;
    }

    public static function recent(int $limit = 5): array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $stmt = $db->getConnection()->query("SELECT * FROM orders ORDER BY id DESC LIMIT $limit");
                return $stmt->fetchAll();
            } catch (Exception $e) {}
        }
        return [];
    }

    public static function totalRevenue(): float
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                return (float)$db->getConnection()->query("SELECT COALESCE(SUM(total_amount), 0) FROM orders")->fetchColumn();
            } catch (Exception $e) {}
        }
        return 0;
    }

    public static function revenueByMonth(int $months = 6): array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $stmt = $db->getConnection()->query(
                    "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month,
                            COUNT(*) AS total_orders,
                            COALESCE(SUM(total_amount), 0) AS revenue
                     FROM orders
                     WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL $months MONTH)
                     GROUP BY month ORDER BY month ASC"
                );
                return $stmt->fetchAll();
            } catch (Exception $e) {}
        }
        return [];
    }

    public static function countByStatus(): array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $stmt = $db->getConnection()->query(
                    "SELECT order_status, COUNT(*) AS cnt FROM orders GROUP BY order_status"
                );
                return $stmt->fetchAll();
            } catch (Exception $e) {}
        }
        return [];
    }
}
