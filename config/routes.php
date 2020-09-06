<?php

$route->add('get', '/', function () use ($container) {
    $pdo = $container['db'];
    var_dump($pdo);
    return 'estamos na home';
});

$route->add('GET', '/projects/(\d+)', function ($params) {
    return 'listando projeto com id ' . $params[1];
});