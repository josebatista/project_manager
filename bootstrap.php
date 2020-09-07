<?php

use JBP\Framework\Exceptions\HttpException;
use JBP\Framework\Response;
use JBP\Framework\Router;

require __DIR__ . "/vendor/autoload.php";

$route = new Router();
require __DIR__ . "/config/containers.php";
require __DIR__ . "/config/routes.php";

try {
    $result = $route->run();

    $params = [
        'container' => $container,
        'params' => $result['params']
    ];

    $response = new Response();
    $response($result['action'], $params);

} catch (HttpException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
