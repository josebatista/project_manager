<?php

use App\Models\Users;
use Laminas\EventManager\EventManager;

$container['events'] = function () {
    return new EventManager;
};

$container['db'] = function () {
    $dsn = 'mysql:host=db;dbname=project_manager';
    $username = 'root';
    $password = 'root';
    $options = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ];

    $pdo = new \PDO($dsn, $username, $password, $options);

    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $pdo;
};

$container['users_model'] = function ($c) {
    return new Users($c);
};

return $container;
