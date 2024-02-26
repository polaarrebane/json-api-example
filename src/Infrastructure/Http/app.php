<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use App\Infrastructure\Http\Controller\BookController;
use App\Infrastructure\Http\ErrorHandler\JsonApiErrorRenderer;
use App\Infrastructure\Http\Middleware\JsonApiContentNegotiationMiddleware;
use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Slim\Handlers\ErrorHandler;

const JSON_API_CONTENT_TYPE = 'application/vnd.api+json';
const PATH_TO_CONFIG = __DIR__ . '/../../../config/';

(Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..'))->load();

$container = (new ContainerBuilder())
    ->addDefinitions(PATH_TO_CONFIG . 'autowiring.php')
    ->addDefinitions(PATH_TO_CONFIG . 'ecotone.php')
    ->addDefinitions(PATH_TO_CONFIG . 'app.php')
    ->useAttributes(true)
    ->build();

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
