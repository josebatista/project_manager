<?php

use APP\Models\Users;

$route->add('get', '/', function () {
    return 'estamos na home';
});

$route->add('GET', '/users/(\d+)', '\APP\Controllers\UsersController::show');