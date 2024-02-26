<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controller\BookController;
use App\Infrastructure\Http\ErrorHandler\JsonApiErrorRenderer;
use App\Infrastructure\Http\Middleware\JsonApiContentNegotiationMiddleware;
use DI\Bridge\Slim\Bridge;
use Slim\Handlers\ErrorHandler;

const JSON_API_CONTENT_TYPE = 'application/vnd.api+json';

$container = require __DIR__ . '/../container.php';

$slim = Bridge::create($container);
$slim->addRoutingMiddleware();
$slim->add(new JsonApiContentNegotiationMiddleware());
$errorMiddleware = $slim->addErrorMiddleware(true, false, false);

/** @var ErrorHandler $errorHandler */
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType(JSON_API_CONTENT_TYPE);
$errorHandler->registerErrorRenderer(JSON_API_CONTENT_TYPE, JsonApiErrorRenderer::class);

$slim->post('/books', [BookController::class, 'create']);

$slim->run();
