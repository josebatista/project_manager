<?php

use JBP\Framework\Exceptions\HttpException;
use JBP\Framework\Router;

require __DIR__ . "/vendor/autoload.php";

$route = new Router();
require __DIR__ . "/config/containers.php";
require __DIR__ . "/config/routes.php";

try {
    echo $route->run();
} catch (HttpException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
