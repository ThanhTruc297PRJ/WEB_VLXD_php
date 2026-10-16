<?php

class Contact
{
    public static function create(array $data): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $stmt = $db->getConnection()->prepare(
            "INSERT INTO contacts (name, phone, subject, message) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['name'], $data['phone'], $data['subject'], $data['message'],
        ]);
    }

    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return null;

        $stmt = $db->getConnection()->prepare("SELECT * FROM contacts WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function markRead(int $id): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $stmt = $db->getConnection()->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function delete(int $id): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $stmt = $db->getConnection()->prepare("DELETE FROM contacts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function unreadCount(): int
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return 0;
        try {
            return (int)$db->getConnection()->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
        } catch (Exception $e) { return 0; }
    }

    public static function count(): int
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return 0;
        try {
            return (int)$db->getConnection()->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
        } catch (Exception $e) { return 0; }
    }
}
