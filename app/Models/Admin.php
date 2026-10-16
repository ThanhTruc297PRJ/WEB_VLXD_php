<?php

class Admin
{
    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return null;

        $stmt = $db->getConnection()->prepare("SELECT * FROM admins WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findByUsername(string $username): ?array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return null;

        $stmt = $db->getConnection()->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function count(): int
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return 0;
        try {
            return (int)$db->getConnection()->query("SELECT COUNT(*) FROM admins")->fetchColumn();
        } catch (Exception $e) { return 0; }
    }
}
