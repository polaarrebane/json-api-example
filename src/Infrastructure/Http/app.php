<?php

declare(strict_types=1);

use App\Infrastructure\Http\ErrorHandler\JsonApiErrorRenderer;
use App\Infrastructure\Http\InvocationStrategy\ApiInvocationStrategy;
use App\Infrastructure\Http\Middleware\InclusionOfRelatedResourcesMiddleware;
use App\Infrastructure\Http\Middleware\JsonApiContentNegotiationMiddleware;
use DI\Bridge\Slim\Bridge;
use League\Config\Configuration;
use Slim\Handlers\ErrorHandler;

require __DIR__ . '/routes.php';

const JSON_API_CONTENT_TYPE = 'application/vnd.api+json';

$container = require __DIR__ . '/../container.php';

$config = $container->get(Configuration::class);

$slim = Bridge::create($container);
$slim->setBasePath($config->get('app.api_base_path'));


$routeCollector = $slim->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy($container->make(ApiInvocationStrategy::class));

$slim->addRoutingMiddleware();
$slim = routes($slim);

$slim->add(new JsonApiContentNegotiationMiddleware());
$slim->add(new InclusionOfRelatedResourcesMiddleware());

$errorMiddleware = $slim->addErrorMiddleware(true, false, false);
/** @var ErrorHandler $errorHandler */
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType(JSON_API_CONTENT_TYPE);
$errorHandler->registerErrorRenderer(JSON_API_CONTENT_TYPE, JsonApiErrorRenderer::class);


$slim->run();
