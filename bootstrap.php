<?php

use JBP\Framework\Exceptions\HttpException;
use JBP\Framework\Response;
use JBP\Framework\Router;

require __DIR__ . "/vendor/autoload.php";

$route = new Router();
require __DIR__ . "/config/containers.php";
require __DIR__ . "/config/middlewares.php";
require __DIR__ . "/config/events.php";
require __DIR__ . "/config/routes.php";

try {
    $result = $route->run();

    $params = [
        'container' => $container,
        'params' => $result['params']
    ];

    $response = new Response();

    foreach ($middlewares['before'] as $middleware) {
        $middleware($container);
    }

    $response($result['action'], $params);

    foreach ($middlewares['after'] as $middleware) {
        $middleware($container);
    }


} catch (HttpException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
