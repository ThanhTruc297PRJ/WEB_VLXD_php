<?php

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, string $handler): void
    {
        $this->routes[] = [
            'method'  => $method,
            'path'    => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $url): void
    {
        $url = trim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['path']);

            if ($route['method'] === $method && preg_match($pattern, $url, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->callHandler($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        echo '<h1>404 - Trang không tồn tại</h1>';
        echo '<p><a href="' . url('/') . '">Quay về trang chủ</a></p>';
    }

    private function convertToRegex(string $path): string
    {
        $path = trim($path, '/');
        $path = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $path . '$#';
    }

    private function callHandler(string $handler, array $params): void
    {
        [$controllerName, $method] = explode('@', $handler);

        $controllerFile = ROOT_PATH . '/app/Controllers/' . str_replace('\\', '/', $controllerName) . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(500);
            echo "Controller file not found: $controllerName";
            return;
        }

        require_once $controllerFile;

        $className = basename(str_replace('/', DIRECTORY_SEPARATOR, $controllerName));

        $controller = new $className();

        if (!method_exists($controller, $method)) {
            http_response_code(500);
            echo "Method not found: $className@$method";
            return;
        }

        call_user_func_array([$controller, $method], $params);
    }
}
