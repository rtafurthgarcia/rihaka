<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

use App\Core\Router;

$app = AppFactory::create();

Router::defineRoutes($app);

$app->run();