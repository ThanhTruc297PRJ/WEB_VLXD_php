<?php

define('ROOT_PATH', dirname(__DIR__));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ROOT_PATH . '/config/app.php';
require_once ROOT_PATH . '/core/Database.php';
require_once ROOT_PATH . '/core/Router.php';
require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/core/helpers.php';

class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        // Đăng nhập / Đăng ký Khách hàng
        $this->router->get('login',              'AuthController@login');
        $this->router->post('login',             'AuthController@handleLogin');
        $this->router->get('register',           'AuthController@register');
        $this->router->post('register',          'AuthController@handleRegister');
        $this->router->get('verify',             'AuthController@verify');
        $this->router->post('verify',            'AuthController@handleVerify');
        $this->router->get('resend-otp',         'AuthController@resendOtp');
        $this->router->get('logout',             'AuthController@logout');

        // Tài khoản khách hàng
        $this->router->get('account/orders',     'AccountController@orders');
        $this->router->get('account/profile',    'AccountController@profile');
        $this->router->post('account/profile/update',   'AccountController@updateProfile');
        $this->router->post('account/profile/password', 'AccountController@changePassword');

        // Trang khách hàng
        $this->router->get('',                   'HomeController@index');
        $this->router->get('products',           'ProductController@index');
        $this->router->get('product/{id}',       'ProductController@detail');
        $this->router->get('cart',               'CartController@index');
        $this->router->post('cart',              'CartController@handle');
        $this->router->get('checkout',           'CheckoutController@index');
        $this->router->post('checkout',          'CheckoutController@process');
        $this->router->get('estimate',           'EstimateController@index');
        $this->router->get('quote',              'QuoteController@index');
        $this->router->post('quote',             'QuoteController@submit');
        $this->router->get('about',              'AboutController@index');
        $this->router->get('contact',            'ContactController@index');
        $this->router->post('contact',           'ContactController@send');

        // Đăng nhập / Đăng xuất Admin
        $this->router->get('admin/login',        'Admin/AuthController@login');
        $this->router->post('admin/login',       'Admin/AuthController@authenticate');
        $this->router->get('admin/logout',       'Admin/AuthController@logout');

        // Trang quản trị Admin (yêu cầu đăng nhập)
        $this->router->get('admin',              'Admin/DashboardController@index');
        $this->router->get('admin/products',     'Admin/ProductController@index');
        $this->router->post('admin/products',    'Admin/ProductController@store');
        $this->router->get('admin/products/delete/{id}', 'Admin/ProductController@delete');
        $this->router->get('admin/products/delete-image/{id}', 'Admin/ProductController@deleteImage');
        $this->router->get('admin/orders',       'Admin/OrderController@index');
        $this->router->post('admin/orders',      'Admin/OrderController@updateStatus');
        $this->router->get('admin/customers',    'Admin/CustomerController@index');
        $this->router->get('admin/customers/detail', 'Admin/CustomerController@detail');
        $this->router->get('admin/categories',   'Admin/CategoryController@index');
        $this->router->get('admin/categories/edit', 'Admin/CategoryController@edit');
        $this->router->post('admin/categories',  'Admin/CategoryController@store');
        $this->router->get('admin/categories/delete', 'Admin/CategoryController@delete');
        $this->router->get('admin/contacts',     'Admin/ContactController@index');
        $this->router->get('admin/contacts/mark-read', 'Admin/ContactController@markRead');
        $this->router->get('admin/contacts/delete', 'Admin/ContactController@delete');
        $this->router->get('admin/revenue',      'Admin/RevenueController@index');
        $this->router->get('admin/settings',     'Admin/SettingController@index');
        $this->router->post('admin/settings/store',    'Admin/SettingController@updateStore');
        $this->router->post('admin/settings/bank',     'Admin/SettingController@updateBank');
        $this->router->post('admin/settings/shipping', 'Admin/SettingController@updateShipping');
        $this->router->get('admin/quotes',       'Admin/QuoteController@index');
        $this->router->post('admin/quotes',      'Admin/QuoteController@updateStatus');
    }

    public function run(): void
    {
        $url = $_GET['url'] ?? '';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->router->dispatch($url);
    }
}
