<?php

class Controller
{
    protected function view(string $viewName, array $data = [], string $layout = 'main'): void
    {
        extract($data);

        $viewFile = ROOT_PATH . '/app/Views/' . $viewName . '.php';

        if (!file_exists($viewFile)) {
            echo "View not found: $viewName";
            return;
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === 'none') {
            echo $content;
        } else {
            $layoutFile = ROOT_PATH . '/app/Views/layouts/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        }
    }

    protected function requireAdmin(): bool
    {
        if (empty($_SESSION['admin_id'])) {
            $this->redirect('admin/login');
            return false;
        }
        return true;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . url($url));
        exit;
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
