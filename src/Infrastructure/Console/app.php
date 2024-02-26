<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;

$container = require __DIR__ . '/../container.php';

$application = new Application();
$application->run();