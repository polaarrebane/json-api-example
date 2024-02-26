<?php

declare(strict_types=1);

use App\Infrastructure\Console\Command\MigrationCompile;
use App\Infrastructure\Console\Command\MigrationRollback;
use App\Infrastructure\Console\Command\MigrationRun;
use App\Infrastructure\Console\Command\SchemaDump;
use Symfony\Component\Console\Application;

$container = require __DIR__ . '/../container.php';

$application = $container->get(Application::class);

$application->add($container->get(MigrationCompile::class));
$application->add($container->get(MigrationRun::class));
$application->add($container->get(MigrationRollback::class));
$application->add($container->get(SchemaDump::class));

$application->run();
