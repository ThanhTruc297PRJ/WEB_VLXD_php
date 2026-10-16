<?php

/**
 * Front Controller - Entry point cho toàn bộ ứng dụng MVC
 * Mọi request đều đi qua file này, được xử lý bởi Router
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/App.php';

$app = new App();
$app->run();
