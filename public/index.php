<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Core\Router;
use App\Core\SessionHelper;

// Make sure use_strict_mode is enabled.
// use_strict_mode is mandatory for security reasons.
ini_set('session.use_strict_mode', 1);
SessionHelper::startSession();

$app = AppFactory::create();

(Dotenv\Dotenv::createImmutable(__DIR__ . '/../config/', ['Database.env', 'App.env']))->load();

// Parse json, form data and xml
$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, true, true);

Router::defineRoutes($app);

$app->run();