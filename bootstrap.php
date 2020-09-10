<?php

use JBP\Framework\App;

$composer = require __DIR__ . "/vendor/autoload.php";

require __DIR__ . '/config/modules.php';

$app = new App($composer, $modules);
$app->run();
