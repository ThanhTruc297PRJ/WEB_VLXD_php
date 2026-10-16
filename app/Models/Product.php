<?php

class Product
{
    public static function all(?int $limit = null, ?int $catId = null, ?string $search = null): array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $sql = "SELECT p.*, c.name as category_name
                        FROM products p
                        JOIN categories c ON p.category_id = c.id
                        WHERE 1=1";
                $params = [];

                if ($catId) {
                    $sql .= " AND p.category_id = :cat_id";
                    $params['cat_id'] = $catId;
                }
                if ($search) {
                    $sql .= " AND (p.name LIKE :search OR p.brand LIKE :search OR p.sku LIKE :search)";
                    $params['search'] = "%$search%";
                }

                $sql .= " ORDER BY p.is_featured DESC, p.id DESC";

                if ($limit) {
                    $sql .= " LIMIT " . (int)$limit;
                }

                $stmt = $db->getConnection()->prepare($sql);
                $stmt->execute($params);
                $data = $stmt->fetchAll();
                if (!empty($data)) return $data;
            } catch (Exception $e) {}
        }

        return self::mockFiltered($limit, $catId, $search);
    }

    public static function find($idOrSlug): ?array
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                $stmt = $db->getConnection()->prepare(
                    "SELECT p.*, c.name as category_name
                     FROM products p
                     JOIN categories c ON p.category_id = c.id
                     WHERE p.id = :val OR p.slug = :val2
                     LIMIT 1"
                );
                $stmt->execute(['val' => $idOrSlug, 'val2' => $idOrSlug]);
                $item = $stmt->fetch();
                if ($item) return $item;
            } catch (Exception $e) {}
        }

        foreach (self::mock() as $p) {
            if ($p['id'] == $idOrSlug || $p['slug'] == $idOrSlug) return $p;
        }
        return null;
    }

    public static function count(): int
    {
        $db = Database::getInstance();
        if ($db->isConnected()) {
            try {
                return (int)$db->getConnection()->query("SELECT COUNT(*) FROM products")->fetchColumn();
            } catch (Exception $e) {}
        }
        return count(self::mock());
    }

    public static function store(array $data): int
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return 0;

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name']), '-'));

        $stmt = $db->getConnection()->prepare(
            "INSERT INTO products (category_id, name, slug, sku, unit, price, price_negotiable, specification, brand, description, image, is_featured)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['category_id'], $data['name'], $slug, $data['sku'],
            $data['unit'], $data['price'], $data['price_negotiable'] ?? 0,
            $data['specification'], $data['brand'], $data['description'],
            $data['image'], $data['is_featured'] ?? 0,
        ]);
        return (int)$db->getConnection()->lastInsertId();
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

        $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $db->getConnection()->prepare($sql);
        return $stmt->execute($values);
    }

    public static function destroy(int $id): bool
    {
        $db = Database::getInstance();
        if (!$db->isConnected()) return false;

        $stmt = $db->getConnection()->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private static function mockFiltered(?int $limit, ?int $catId, ?string $search): array
    {
        $products = self::mock();

        if ($catId !== null) {
            $products = array_filter($products, fn($p) => $p['category_id'] == $catId);
        }
        if ($search) {
            $products = array_filter($products, fn($p) =>
                stripos($p['name'], $search) !== false || stripos($p['brand'], $search) !== false
            );
        }
        if ($limit) {
            $products = array_slice(array_values($products), 0, $limit);
        }
        return array_values($products);
    }

    private static function mock(): array
    {
        return [
            ['id' => 1, 'category_id' => 1, 'category_name' => 'Xi Măng & Vữa', 'name' => 'Xi Măng Hà Tiên Đa Dụng PCB40', 'slug' => 'xi-mang-ha-tien-pcb40', 'sku' => 'XM-HT-40', 'unit' => 'Bao', 'price' => 89000, 'price_negotiable' => 0, 'specification' => '50kg/bao - TCVN 6260:2009', 'brand' => 'Hà Tiên', 'description' => 'Xi măng Pooc lăng hỗn hợp PCB40 Hà Tiên độ dẻo cao, đông kết chuẩn.', 'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=600&auto=format&fit=crop&q=80', 'stock' => 500, 'is_featured' => 1],
            ['id' => 2, 'category_id' => 1, 'category_name' => 'Xi Măng & Vữa', 'name' => 'Xi Măng INSEE Đa Dụng Easy Clean', 'slug' => 'xi-mang-insee-easy-clean', 'sku' => 'XM-INSEE-01', 'unit' => 'Bao', 'price' => 94000, 'price_negotiable' => 0, 'specification' => '50kg/bao - Công nghệ đột phá', 'brand' => 'INSEE', 'description' => 'Xi măng cao cấp INSEE giúp bề mặt vữa xây tô láng mịn.', 'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=600&auto=format&fit=crop&q=80', 'stock' => 350, 'is_featured' => 1],
            ['id' => 3, 'category_id' => 2, 'category_name' => 'Cát & Đá Xây Dựng', 'name' => 'Cát Vàng Hạt Lớn Đổ Bê Tông', 'slug' => 'cat-vang-do-be-tong', 'sku' => 'CAT-VANG-01', 'unit' => 'm3', 'price' => 380000, 'price_negotiable' => 0, 'specification' => 'Hạt sạch 1.5 - 2.5mm', 'brand' => 'Miền Nam', 'description' => 'Cát hạt to màu vàng đều, không lẫn sét hữu cơ.', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&auto=format&fit=crop&q=80', 'stock' => 200, 'is_featured' => 1],
            ['id' => 4, 'category_id' => 2, 'category_name' => 'Cát & Đá Xây Dựng', 'name' => 'Đá Xanh 1x2 Đổ Sàn Dầm Cột', 'slug' => 'da-xanh-1x2', 'sku' => 'DA-1X2-XANH', 'unit' => 'm3', 'price' => 420000, 'price_negotiable' => 0, 'specification' => 'Kích cỡ 10x28mm', 'brand' => 'Hóa An', 'description' => 'Đá xanh Hóa An cường độ chịu nén vượt trội.', 'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=600&auto=format&fit=crop&q=80', 'stock' => 150, 'is_featured' => 1],
            ['id' => 5, 'category_id' => 3, 'category_name' => 'Sắt Thép Xây Dựng', 'name' => 'Thép Cây Vằn D10 Hòa Phát CB300', 'slug' => 'thep-cay-d10-hoa-phat', 'sku' => 'THEP-HP-D10', 'unit' => 'Cây', 'price' => 128000, 'price_negotiable' => 0, 'specification' => 'Dài 11.7m/cây - CB300V', 'brand' => 'Hòa Phát', 'description' => 'Thép cây vằn đường kính 10mm chính hãng Hòa Phát.', 'image' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?w=600&auto=format&fit=crop&q=80', 'stock' => 1000, 'is_featured' => 1],
            ['id' => 6, 'category_id' => 3, 'category_name' => 'Sắt Thép Xây Dựng', 'name' => 'Thép Cây Vằn D16 Pomina CB400', 'slug' => 'thep-cay-d16-pomina', 'sku' => 'THEP-PM-D16', 'unit' => 'Cây', 'price' => 335000, 'price_negotiable' => 0, 'specification' => 'Dài 11.7m/cây - CB400', 'brand' => 'Pomina', 'description' => 'Thép gân Pomina mác CB400 chuyên kết cấu chịu lực.', 'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=600&auto=format&fit=crop&q=80', 'stock' => 600, 'is_featured' => 1],
            ['id' => 7, 'category_id' => 4, 'category_name' => 'Gạch Xây Dựng', 'name' => 'Gạch Tuynel 4 Lỗ Bình Dương', 'slug' => 'gach-tuynel-4-lo-binh-duong', 'sku' => 'GACH-4L-BD', 'unit' => 'Viên', 'price' => 1250, 'price_negotiable' => 0, 'specification' => 'Kích thước 80x80x180mm', 'brand' => 'Bình Dương', 'description' => 'Gạch nung lò tuynel chín đều, độ hút nước thấp.', 'image' => 'https://images.unsplash.com/photo-1590069261209-f8e9b8642343?w=600&auto=format&fit=crop&q=80', 'stock' => 50000, 'is_featured' => 1],
            ['id' => 8, 'category_id' => 5, 'category_name' => 'Sơn & Chống Thấm', 'name' => 'Phụ Gia Chống Thấm Sika Latex TH (Can 5L)', 'slug' => 'sika-latex-th-5l', 'sku' => 'SIKA-LT-5L', 'unit' => 'Can', 'price' => 410000, 'price_negotiable' => 0, 'specification' => 'Can 5 Lít - Nhũ tương polyme', 'brand' => 'Sika', 'description' => 'Phụ gia trộn với xi măng và cát làm tăng độ kết dính, chống thấm.', 'image' => 'https://images.unsplash.com/photo-1562259949-e8e7689d7828?w=600&auto=format&fit=crop&q=80', 'stock' => 80, 'is_featured' => 1],
        ];
    }
}
