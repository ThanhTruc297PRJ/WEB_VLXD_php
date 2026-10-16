<?php

require_once ROOT_PATH . '/app/Models/Admin.php';

class AuthController extends Controller
{
    public function login(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('admin');
            return;
        }
        $this->view('admin/login', ['error' => ''], 'none');
    }

    public function authenticate(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('admin');
            return;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $this->view('admin/login', ['error' => 'Vui lòng nhập đầy đủ tài khoản và mật khẩu.'], 'none');
            return;
        }

        $db = Database::getInstance();
        if (!$db->isConnected()) {
            $this->view('admin/login', ['error' => 'Không thể kết nối cơ sở dữ liệu.'], 'none');
            return;
        }

        try {
            $admin = Admin::findByUsername($username);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['fullname'];
                $_SESSION['admin_username'] = $admin['username'];
                $this->redirect('admin');
                return;
            }

            $this->view('admin/login', ['error' => 'Tài khoản hoặc mật khẩu không đúng.'], 'none');
        } catch (Exception $e) {
            $this->view('admin/login', ['error' => 'Lỗi hệ thống: ' . $e->getMessage()], 'none');
        }
    }

    public function logout(): void
    {
        unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['admin_username']);
        $this->redirect('admin/login');
    }

    private function isLoggedIn(): bool
    {
        return !empty($_SESSION['admin_id']);
    }
}
