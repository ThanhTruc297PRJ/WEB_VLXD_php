<?php

require_once ROOT_PATH . '/app/Models/Category.php';
require_once ROOT_PATH . '/app/Models/Product.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $categories = Category::all();
        $featured_products = Product::all(8);
        $db_connected = Database::getInstance()->isConnected();

        $this->view('home/index', [
            'page_title'        => 'Trang Chủ - Nhà Cung Cấp Vật Liệu Xây Dựng Uy Tín',
            'categories'        => $categories,
            'featured_products' => $featured_products,
            'db_connected'      => $db_connected,
        ]);
    }
}
