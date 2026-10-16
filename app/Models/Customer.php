<?php

class Customer
{
    public static function findByEmail(string $email): ?array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return null;

        $stmt = $db->getConnection()->prepare("SELECT * FROM customers WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function find(int $id): ?array
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return null;

        $stmt = $db->getConnection()->prepare("SELECT * FROM customers WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return 0;

        $stmt = $db->getConnection()->prepare(
            "INSERT INTO customers (fullname, phone, email, password, address) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['fullname'],
            $data['phone'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['address'] ?? null,
        ]);
        return (int) $db->getConnection()->lastInsertId();
    }

    public static function count(): int
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return 0;
        try {
            return (int)$db->getConnection()->query("SELECT COUNT(*) FROM customers")->fetchColumn();
        } catch (Exception $e) { return 0; }
    }

    public static function update(int $id, array $data): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $fields = [];
        $values = [];
        foreach ($data as $key => $val) {
            $fields[] = "`$key` = ?";
            $values[] = $val;
        }
        $values[] = $id;
        $sql = "UPDATE customers SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->getConnection()->prepare($sql);
        return $stmt->execute($values);
    }
}
