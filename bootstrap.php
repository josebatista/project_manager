<?php

use JBP\Framework\App;

require __DIR__ . "/vendor/autoload.php";

require __DIR__ . "/config/containers.php";
require __DIR__ . "/config/events.php";

$app = new App($container);

$router = $app->getRouter();

require __DIR__ . "/config/middlewares.php";
require __DIR__ . "/config/routes.php";

$app->run();
