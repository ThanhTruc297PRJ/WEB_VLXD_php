<?php

class OrderItem
{
    public static function findByOrderId(int $orderId): array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return [];

        try {
            $stmt = $db->getConnection()->prepare("SELECT * FROM order_items WHERE order_id = ? ORDER BY id");
            $stmt->execute([$orderId]);
            return $stmt->fetchAll();
        } catch (Exception $e) { return []; }
    }

    public static function findByOrderIds(array $ids): array
    {
        if (empty($ids)) return [];

        $db = Database::getInstance();
        if (!$db->isConnected()) return [];

        try {
            $ph = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $db->getConnection()->prepare("SELECT * FROM order_items WHERE order_id IN ($ph) ORDER BY order_id, id");
            $stmt->execute($ids);
            $grouped = [];
            foreach ($stmt->fetchAll() as $item) {
                $grouped[$item['order_id']][] = $item;
            }
            return $grouped;
        } catch (Exception $e) { return []; }
    }
}
