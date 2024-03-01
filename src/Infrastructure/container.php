<?php

declare(strict_types=1);

use DI\ContainerBuilder;

require __DIR__ . '/../../vendor/autoload.php';

const PATH_TO_CONFIG = __DIR__ . '/../../config/';

(Dotenv\Dotenv::createImmutable(__DIR__ . '/../..'))->load();

$container = (new ContainerBuilder())
    ->addDefinitions(PATH_TO_CONFIG . 'autowiring.php')
    ->addDefinitions(PATH_TO_CONFIG . 'app.php')
    ->addDefinitions(PATH_TO_CONFIG . 'ecotone.php')
    ->addDefinitions(PATH_TO_CONFIG . 'database.php')
    ->useAttributes(true)
    ->build();

return $container;
