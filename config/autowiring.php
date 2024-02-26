<?php

declare(strict_types=1);

use App\Infrastructure\Http\Service\AuthorServiceInterface;
use App\Infrastructure\Http\Service\AuthorServiceStub;

return [
    AuthorServiceInterface::class => \DI\autowire(AuthorServiceStub::class),
];