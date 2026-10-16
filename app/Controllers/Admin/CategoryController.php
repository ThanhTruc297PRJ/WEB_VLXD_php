<?php

require_once ROOT_PATH . '/app/Models/Category.php';

class CategoryController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $categories = [];
        $productCounts = [];

        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
                $categories = $stmt->fetchAll();

                $stmt = $pdo->query("SELECT category_id, COUNT(*) AS cnt FROM products GROUP BY category_id");
                foreach ($stmt->fetchAll() as $row) {
                    $productCounts[$row['category_id']] = $row['cnt'];
                }
            } catch (Exception $e) {}
        }

        $this->view('admin/categories', [
            'page_title'     => 'Quản Lý Danh Mục',
            'categories'     => $categories,
            'product_counts' => $productCounts,
            'edit_cat'       => null,
        ], 'admin');
    }

    public function edit(): void
    {
        if (!$this->requireAdmin()) return;

        $id = (int)($_GET['id'] ?? 0);
        $db = Database::getInstance();
        $pdo = $db->isConnected() ? $db->getConnection() : null;

        $categories = [];
        $productCounts = [];
        $editCat = null;

        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
                $categories = $stmt->fetchAll();

                $stmt = $pdo->query("SELECT category_id, COUNT(*) AS cnt FROM products GROUP BY category_id");
                foreach ($stmt->fetchAll() as $row) {
                    $productCounts[$row['category_id']] = $row['cnt'];
                }

                if ($id > 0) {
                    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
                    $stmt->execute([$id]);
                    $editCat = $stmt->fetch();
                }
            } catch (Exception $e) {}
        }

        $this->view('admin/categories', [
            'page_title'     => 'Quản Lý Danh Mục',
            'categories'     => $categories,
            'product_counts' => $productCounts,
            'edit_cat'       => $editCat,
        ], 'admin');
    }

    public function store(): void
    {
        if (!$this->requireAdmin()) return;

        $id   = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $icon = trim($_POST['icon'] ?? 'fa-cubes');
        $desc = trim($_POST['description'] ?? '');
        $status = (int)($_POST['status'] ?? 1);

        if (empty($name)) {
            header('Location: ' . url('admin/categories'));
            exit;
        }

        $slug = $this->toSlug($name);

        $db = Database::getInstance();
        if ($db->isConnected()) {
            $pdo = $db->getConnection();
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, icon = ?, description = ?, status = ? WHERE id = ?");
                    $stmt->execute([$name, $slug, $icon, $desc, $status, $id]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, icon, description, status) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $slug, $icon, $desc, $status]);
                }
            } catch (Exception $e) {}
        }

        header('Location: ' . url('admin/categories'));
        exit;
    }

    public function delete(): void
    {
        if (!$this->requireAdmin()) return;

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db = Database::getInstance();
            if ($db->isConnected()) {
                try {
                    $pdo = $db->getConnection();
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
                    $stmt->execute([$id]);
                    if ((int)$stmt->fetchColumn() === 0) {
                        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                        $stmt->execute([$id]);
                    }
                } catch (Exception $e) {}
            }
        }

        header('Location: ' . url('admin/categories'));
        exit;
    }

    private function toSlug(string $str): string
    {
        $map = [
            'à'=>'a','á'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a','ă'=>'a','ắ'=>'a','ằ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a',
            'â'=>'a','ấ'=>'a','ầ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a','đ'=>'d','è'=>'e','é'=>'e','ẻ'=>'e','ẽ'=>'e',
            'ẹ'=>'e','ê'=>'e','ế'=>'e','ề'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e','ì'=>'i','í'=>'i','ỉ'=>'i','ĩ'=>'i',
            'ị'=>'i','ò'=>'o','ó'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o','ô'=>'o','ố'=>'o','ồ'=>'o','ổ'=>'o','ỗ'=>'o',
            'ộ'=>'o','ơ'=>'o','ớ'=>'o','ờ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o','ù'=>'u','ú'=>'u','ủ'=>'u','ũ'=>'u',
            'ụ'=>'u','ư'=>'u','ứ'=>'u','ừ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u','ỳ'=>'y','ý'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y',
        ];
        $str = mb_strtolower($str);
        $str = strtr($str, $map);
        $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
        $str = preg_replace('/[\s-]+/', '-', $str);
        return trim($str, '-');
    }
}
