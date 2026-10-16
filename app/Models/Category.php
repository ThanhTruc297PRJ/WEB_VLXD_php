<?php

class Category
{
    public static function all(): array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $stmt = $db->getConnection()->query(
                    "SELECT * FROM categories WHERE status = 1 ORDER BY id ASC"
                );
                $data = $stmt->fetchAll();
                if (!empty($data)) return $data;
            } catch (Exception $e) {}
        }
        return self::mock();
    }

    public static function find(int $id): ?array
    {
        foreach (self::all() as $cat) {
            if ($cat['id'] == $id) return $cat;
        }
        return null;
    }

    private static function mock(): array
    {
        return [
            ['id' => 1, 'name' => 'Xi Măng & Vữa',       'slug' => 'xi-mang-vua',       'icon' => 'fa-cubes',        'description' => 'Xi măng xây tô, xi măng đa dụng chất lượng cao'],
            ['id' => 2, 'name' => 'Cát & Đá Xây Dựng',    'slug' => 'cat-da-xay-dung',   'icon' => 'fa-mountain',     'description' => 'Cát vàng bê tông, cát xây tô, đá 1x2, đá 4x6'],
            ['id' => 3, 'name' => 'Sắt Thép Xây Dựng',    'slug' => 'sat-thep-xay-dung', 'icon' => 'fa-layer-group',  'description' => 'Thép cuộn, thép cây phi 10, 12, 16 Hòa Phát, Pomina'],
            ['id' => 4, 'name' => 'Gạch Xây Dựng',        'slug' => 'gach-xay-dung',     'icon' => 'fa-th-large',     'description' => 'Gạch tuynel 4 lỗ, gạch đinh, gạch block không nung'],
            ['id' => 5, 'name' => 'Sơn & Chống Thấm',     'slug' => 'son-chong-tham',    'icon' => 'fa-paint-roller', 'description' => 'Sơn ngoại thất, sơn lót, phụ gia chống thấm Sika'],
            ['id' => 6, 'name' => 'Tôn & Xà Gồ Mái',     'slug' => 'ton-xa-go-mai',     'icon' => 'fa-warehouse',    'description' => 'Tôn lạnh PU 3 lớp, xà gồ thép mạ kẽm C, Z'],
        ];
    }
}
