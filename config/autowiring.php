<?php

declare(strict_types=1);

use App\Domain\Repository\BookRepositoryInterface;
use App\Domain\Service\BookServiceInterface;
use App\Infrastructure\Http\Service\AuthorServiceInterface;
use App\Infrastructure\Http\Service\AuthorServiceStub;
use App\Infrastructure\RepositoryImplementation\BookSqlRepositoryImplementation;
use App\Infrastructure\ServiceImplementation\BookServiceImplementation;

return [
    AuthorServiceInterface::class => \DI\autowire(AuthorServiceStub::class),
    BookRepositoryInterface::class => \DI\autowire(BookSqlRepositoryImplementation::class),
    BookServiceInterface::class => \DI\autowire(BookServiceImplementation::class),
];