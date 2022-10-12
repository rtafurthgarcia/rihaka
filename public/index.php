<?php

use Slim\Factory\AppFactory;
use App\Core\Router;
use App\Core\SessionHelper;
use App\Core\CustomErrorRenderer;

require __DIR__ . '/../vendor/autoload.php';

// Make sure use_strict_mode is enabled.
// use_strict_mode is mandatory for security reasons.
ini_set('session.use_strict_mode', 1);
SessionHelper::startSession();

$app = AppFactory::create();

// Parse json, form data and xml
$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Get the default error handler and register my custom error renderer.
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->registerErrorRenderer('text/html', CustomErrorRenderer::class);

Router::defineRoutes($app);

$app->run();