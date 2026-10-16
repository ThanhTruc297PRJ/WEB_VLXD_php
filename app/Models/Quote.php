<?php

class Quote
{
    public static function all(): array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $stmt = $db->getConnection()->query("SELECT * FROM quotes ORDER BY id DESC");
                return $stmt->fetchAll();
            } catch (Exception $e) {}
        }
        return self::mock();
    }

    public static function recent(int $limit = 5): array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $stmt = $db->getConnection()->query("SELECT * FROM quotes ORDER BY id DESC LIMIT $limit");
                return $stmt->fetchAll();
            } catch (Exception $e) {}
        }
        return self::mock();
    }

    public static function count(): int
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                return (int)$db->getConnection()->query("SELECT COUNT(*) FROM quotes")->fetchColumn();
            } catch (Exception $e) {}
        }
        return count(self::mock());
    }

    public static function store(array $data): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return true;

        $stmt = $db->getConnection()->prepare(
            "INSERT INTO quotes (fullname, phone, email, project_address, project_type, delivery_date, material_notes, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, 'Mới tiếp nhận')"
        );
        return $stmt->execute([
            $data['fullname'], $data['phone'], $data['email'],
            $data['project_address'], $data['project_type'],
            $data['delivery_date'], $data['material_notes'],
        ]);
    }

    public static function updateStatus(int $id, string $status): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return true;

        $stmt = $db->getConnection()->prepare("UPDATE quotes SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    private static function mock(): array
    {
        return [
            ['id' => 1, 'fullname' => 'Kỹ Sư Trần Văn Long', 'phone' => '0912345678', 'email' => 'longtran.cons@gmail.com', 'project_address' => 'KĐT Vạn Phúc, TP. Thủ Đức', 'project_type' => 'Biệt thự 3 tầng', 'material_notes' => '15 tấn thép Pomina, 120 bao xi măng INSEE, 35m3 cát bê tông', 'delivery_date' => '2026-11-01', 'status' => 'Mới tiếp nhận', 'created_at' => date('Y-m-d H:i')],
            ['id' => 2, 'fullname' => 'Anh Nguyễn Hoàng Nam', 'phone' => '0987654321', 'email' => 'nam.hoang@yahoo.com', 'project_address' => 'Đường số 8, P. Linh Xuân, TP. Thủ Đức', 'project_type' => 'Nhà phố', 'material_notes' => '40 bao xi măng Hà Tiên, 12.000 viên gạch tuynel', 'delivery_date' => '2026-10-25', 'status' => 'Đang báo giá', 'created_at' => date('Y-m-d H:i')],
        ];
    }
}
