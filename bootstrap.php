<?php

use JBP\Framework\Exceptions\HttpException;
use JBP\Framework\Router;

require __DIR__ . "/vendor/autoload.php";

$route = new Router();

$route->add('get', '/', function () {
    return 'estamos na home';
});

$route->add('GET', '/projects/(\d+)', function ($params) {
    return 'listando projeto com id ' . $params[1];
});

try {
    echo $route->run();
} catch (HttpException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
