<?php

use APP\Models\Users;

$route->add('get', '/', function () {
    return 'estamos na home';
});

$route->add('GET', '/users/(\d+)', function ($params) use ($container) {

    $user = new Users($container);
    $data = $user->get($params[1]);

    return 'Olá meu nome é ' . $data['name'];
});