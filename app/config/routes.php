<?php

$router->add('get', '/', function () {
    return 'estamos na home';
});

$router->add('GET', '/users/(\d+)', 'App\Controllers\UsersController::show');
