<?php

class ProductImage
{
    public static function getByProductId(int $productId): array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return [];

        try {
            $stmt = $db->getConnection()->prepare(
                "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC, id ASC"
            );
            $stmt->execute([$productId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public static function add(int $productId, string $imagePath, int $sortOrder = 0): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $stmt = $db->getConnection()->prepare(
            "INSERT INTO product_images (product_id, image_path, sort_order) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$productId, $imagePath, $sortOrder]);
    }

    public static function delete(int $id): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $stmt = $db->getConnection()->prepare("DELETE FROM product_images WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return null;

        $stmt = $db->getConnection()->prepare("SELECT * FROM product_images WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
