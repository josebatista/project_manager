<?php

$router->add('get', '/', function () {
    return 'estamos na home';
});

$router->add('GET', '/users/(\d+)', '\APP\Controllers\UsersController::show');
