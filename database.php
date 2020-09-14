<?php

use Pimple\Container;

require __DIR__ . '/vendor/autoload.php';

$c = require __DIR__ . '/app/config/containers.php';
$c = new Container($c);

if (!empty($argv[1]) && $argv[1] === 'fresh') {
    $c['db']->exec("DROP DATABASE IF EXISTS `project_manager`");
    echo 'DATABASE DROPPED!' . PHP_EOL;
}

$files = scandir(__DIR__ . '/database');

foreach ($files as $file) {
    if (!is_dir(__DIR__ . '/database/' . $file)) {
        $sql = file_get_contents(__DIR__ . '/database/' . $file);

        $c['db']->exec($sql);
        echo $file . ' MIGRATED!' . PHP_EOL;
    }
}
