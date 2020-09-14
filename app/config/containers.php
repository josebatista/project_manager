<?php

use App\Models\Users;
use Laminas\EventManager\EventManager;

$container['events'] = function () {
    return new EventManager;
};

$container['settings'] = function () {
    return [
        'db' => [
            'dsn' => 'mysql:host=db;',
            'dbname' => 'project_manager',
            'username' => 'root',
            'password' => 'root',
            'options' => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]
        ]
    ];
};

$container['db'] = function ($c) {
    $dsn = $c['settings']['db']['dsn'] . 'dbname=' . $c['settings']['db']['dbname'];
    $username = $c['settings']['db']['username'];
    $password = $c['settings']['db']['password'];
    $options = $c['settings']['db']['options'];

    $pdo = new \PDO($dsn, $username, $password, $options);

    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $pdo;
};

$container['users_model'] = function ($c) {
    return new Users($c);
};

return $container;
