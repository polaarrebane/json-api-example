<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;

const PATH_TO_CONFIG = __DIR__ . '/../../../config/';

(Dotenv\Dotenv::createImmutable(__DIR__ . '/../../..'))->load();

$container = (new ContainerBuilder())
    ->addDefinitions(PATH_TO_CONFIG . 'autowire.php')
    ->addDefinitions(PATH_TO_CONFIG . 'ecotone.php')
    ->addDefinitions(PATH_TO_CONFIG . 'app.php')
    ->useAttributes(true)
    ->build();

$slim = Bridge::create($container);

$slim->run();
