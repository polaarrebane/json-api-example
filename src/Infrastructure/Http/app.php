<?php

declare(strict_types=1);

use App\Infrastructure\Http\ErrorHandler\JsonApiErrorHandler;
use App\Infrastructure\Http\ErrorHandler\JsonApiErrorRenderer;
use App\Infrastructure\Http\ErrorHandler\JsonApiShutdownHandler;
use App\Infrastructure\Http\InvocationStrategy\ApiInvocationStrategy;
use App\Infrastructure\Http\Middleware\InclusionOfRelatedResourcesMiddleware;
use App\Infrastructure\Http\Middleware\JsonApiContentNegotiationMiddleware;
use DI\Bridge\Slim\Bridge;
use League\Config\Configuration;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/routes.php';

const JSON_API_CONTENT_TYPE = 'application/vnd.api+json';

$container = require __DIR__ . '/../container.php';

$config = $container->get(Configuration::class);

$slim = Bridge::create($container);
$slim->setBasePath($config->get('app.api_base_path'));


$routeCollector = $slim->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy($container->make(ApiInvocationStrategy::class));


$callableResolver = $slim->getCallableResolver();
$responseFactory = $slim->getResponseFactory();

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();


$errorHandler = new JsonApiErrorHandler($callableResolver, $responseFactory);
$shutdownHandler = new JsonApiShutdownHandler($request, $errorHandler, true);



$slim->addRoutingMiddleware();
$slim = routes($slim);
$slim->add(new JsonApiContentNegotiationMiddleware());
$slim->add(new InclusionOfRelatedResourcesMiddleware());


$errorMiddleware = $slim->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);
$errorHandler->registerErrorRenderer(JSON_API_CONTENT_TYPE, JsonApiErrorRenderer::class);
$errorHandler->forceContentType(JSON_API_CONTENT_TYPE);


register_shutdown_function($shutdownHandler);



$slim->run();
