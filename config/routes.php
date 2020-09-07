<?php

use APP\Models\Users;

$route->add('get', '/', function () {
    return 'estamos na home';
});

$route->add('GET', '/users/(\d+)', function ($params) use ($container) {
    return (new \APP\Controllers\UsersController($container))->show($params[1]);
});