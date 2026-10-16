<?php

require_once ROOT_PATH . '/app/Models/Category.php';
require_once ROOT_PATH . '/app/Models/Product.php';
require_once ROOT_PATH . '/app/Models/ProductImage.php';

class ProductController extends Controller
{
    public function index(): void
    {
        $cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : null;
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;

        $categories = Category::all();
        $products = Product::all(null, $cat_id, $search);

        $current_cat_name = 'Tất Cả Sản Phẩm';
        if ($cat_id) {
            $cat = Category::find($cat_id);
            if ($cat) $current_cat_name = $cat['name'];
        }

        $this->view('products/index', [
            'page_title'       => 'Danh Sách Vật Liệu Xây Dựng',
            'categories'       => $categories,
            'products'         => $products,
            'cat_id'           => $cat_id,
            'search'           => $search,
            'current_cat_name' => $current_cat_name,
        ]);
    }

    public function detail(string $id): void
    {
        $product = Product::find($id);

        if (!$product) {
            $this->redirect('products');
            return;
        }

        $related_products = Product::all(4, $product['category_id']);

        $gallery_images = ProductImage::getByProductId((int)$product['id']);

        $this->view('products/detail', [
            'page_title'       => $product['name'],
            'product'          => $product,
            'related_products' => $related_products,
            'gallery_images'   => $gallery_images,
        ]);
    }
}
