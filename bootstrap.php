<?php

use JBP\Framework\App;
use JBP\Framework\Router;

require __DIR__ . "/vendor/autoload.php";

$route = new Router();
require __DIR__ . "/config/containers.php";
require __DIR__ . "/config/events.php";
require __DIR__ . "/config/routes.php";

$app = new App($container, $route);

require __DIR__ . "/config/middlewares.php";

$app->run();
