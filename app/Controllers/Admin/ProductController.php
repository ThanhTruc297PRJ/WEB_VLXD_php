<?php

require_once ROOT_PATH . '/app/Models/Category.php';
require_once ROOT_PATH . '/app/Models/Product.php';
require_once ROOT_PATH . '/app/Models/ProductImage.php';

class ProductController extends Controller
{
    public function index(): void
    {
        if (!$this->requireAdmin()) return;

        $this->view('admin/products', [
            'page_title'  => 'Quản Lý Sản Phẩm Vật Tư',
            'categories'  => Category::all(),
            'products'    => Product::all(),
            'message'     => '',
            'error'       => '',
        ], 'admin');
    }

    public function store(): void
    {
        if (!$this->requireAdmin()) return;

        $action = $_POST['action'] ?? '';

        if ($action === 'edit_product') {
            $this->update();
            return;
        }

        $message = '';
        $error   = '';

        $name = cleanInput($_POST['name'] ?? '');
        if (empty($name)) {
            $error = 'Tên vật liệu không được để trống!';
        } else {
            $imagePath = '/assets/images/no-image.svg';

            if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $uploaded = $this->handleUpload($_FILES['image_file']);
                if ($uploaded['success']) {
                    $imagePath = $uploaded['path'];
                } else {
                    $error = $uploaded['error'];
                }
            }

            if (empty($error)) {
                $db = Database::getInstance();
                if ($db->isConnected()) {
                    try {
                        $newId = Product::store([
                            'category_id'     => (int)($_POST['category_id'] ?? 1),
                            'name'            => $name,
                            'sku'             => cleanInput($_POST['sku'] ?? ('VLXD-' . rand(100, 999))),
                            'unit'            => cleanInput($_POST['unit'] ?? 'Bao'),
                            'price'           => (float)($_POST['price'] ?? 0),
                            'price_negotiable'=> isset($_POST['price_negotiable']) ? 1 : 0,
                            'specification'   => cleanInput($_POST['specification'] ?? ''),
                            'brand'           => cleanInput($_POST['brand'] ?? ''),
                            'description'     => cleanInput($_POST['description'] ?? ''),
                            'image'           => $imagePath,
                            'is_featured'     => isset($_POST['is_featured']) ? 1 : 0,
                        ]);
                        if ($newId > 0) {
                            $this->handleGalleryUpload($newId);
                        }
                        $message = 'Thêm sản phẩm vật liệu mới thành công!';
                    } catch (Exception $e) {
                        $error = 'Lỗi khi lưu sản phẩm: ' . $e->getMessage();
                    }
                } else {
                    $message = 'Chế độ demo: Dữ liệu sản phẩm đã được mô phỏng thêm thành công!';
                }
            }
        }

        $this->view('admin/products', [
            'page_title'  => 'Quản Lý Sản Phẩm Vật Tư',
            'categories'  => Category::all(),
            'products'    => Product::all(),
            'message'     => $message,
            'error'       => $error,
        ], 'admin');
    }

    private function update(): void
    {
        $message = '';
        $error   = '';
        $id = (int)($_POST['product_id'] ?? 0);

        if ($id <= 0) {
            $error = 'Sản phẩm không hợp lệ!';
        } else {
            $data = [
                'name'            => cleanInput($_POST['name'] ?? ''),
                'category_id'     => (int)($_POST['category_id'] ?? 1),
                'unit'            => cleanInput($_POST['unit'] ?? 'Bao'),
                'price'           => (float)($_POST['price'] ?? 0),
                'price_negotiable'=> isset($_POST['price_negotiable']) ? 1 : 0,
                'specification'   => cleanInput($_POST['specification'] ?? ''),
                'brand'           => cleanInput($_POST['brand'] ?? ''),
                'description'     => cleanInput($_POST['description'] ?? ''),
                'is_featured'     => isset($_POST['is_featured']) ? 1 : 0,
            ];

            if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $uploaded = $this->handleUpload($_FILES['image_file']);
                if ($uploaded['success']) {
                    $data['image'] = $uploaded['path'];
                } else {
                    $error = $uploaded['error'];
                }
            }

            if (empty($error)) {
                try {
                    Product::update($id, $data);
                    $this->handleGalleryUpload($id);
                    $message = 'Cập nhật sản phẩm thành công!';
                } catch (Exception $e) {
                    $error = 'Lỗi khi cập nhật: ' . $e->getMessage();
                }
            }
        }

        $this->view('admin/products', [
            'page_title'  => 'Quản Lý Sản Phẩm Vật Tư',
            'categories'  => Category::all(),
            'products'    => Product::all(),
            'message'     => $message,
            'error'       => $error,
        ], 'admin');
    }

    private function handleGalleryUpload(int $productId): void
    {
        if (empty($_FILES['gallery_files']['name'][0])) return;

        $files = $_FILES['gallery_files'];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;

            $file = [
                'name'     => $files['name'][$i],
                'type'     => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i],
            ];

            $uploaded = $this->handleUpload($file);
            if ($uploaded['success']) {
                ProductImage::add($productId, $uploaded['path'], $i);
            }
        }
    }

    private function handleUpload(array $file): array
    {
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowed)) {
            return ['success' => false, 'error' => 'Chỉ chấp nhận file ảnh JPG, PNG, WEBP hoặc GIF.'];
        }
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'File ảnh vượt quá 5MB cho phép.'];
        }

        $ext = match ($file['type']) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            default      => 'jpg',
        };

        $filename = time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
        $uploadDir = ROOT_PATH . '/assets/images/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destination = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => true, 'path' => '/assets/images/products/' . $filename];
        }

        return ['success' => false, 'error' => 'Không thể lưu file ảnh. Vui lòng thử lại.'];
    }

    public function delete(string $id): void
    {
        if (!$this->requireAdmin()) return;

        $db = Database::getInstance();
        if ($db->isConnected()) {
            Product::destroy((int)$id);
            setFlash('success', 'Đã xóa sản phẩm khỏi kho!');
        } else {
            setFlash('success', 'Chế độ demo: Đã mô phỏng xóa sản phẩm ID: ' . $id);
        }
        $this->redirect('admin/products');
    }

    public function deleteImage(string $id): void
    {
        if (!$this->requireAdmin()) return;

        $image = ProductImage::find((int)$id);
        if ($image) {
            $filePath = ROOT_PATH . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            ProductImage::delete((int)$id);
            setFlash('success', 'Đã xóa ảnh khỏi thư viện!');
        }
        $this->redirect('admin/products');
    }
}
