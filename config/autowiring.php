<?php

declare(strict_types=1);

use App\Domain\Repository\AuthorRepositoryInterface;
use App\Domain\Repository\BookRepositoryInterface;
use App\Domain\Service\AuthorServiceInterface as AuthorDomainServiceInterface;
use App\Domain\Service\BookServiceInterface;
use App\Infrastructure\Http\Service\AuthorServiceInterface as AuthorInfrastructureServiceInterface;
use App\Infrastructure\RepositoryImplementation\AuthorSqlRepositoryImplementation;
use App\Infrastructure\RepositoryImplementation\BookSqlRepositoryImplementation;
use App\Infrastructure\ServiceImplementation\AuthorServiceImplementation;
use App\Infrastructure\ServiceImplementation\BookServiceImplementation;

return [
    AuthorRepositoryInterface::class => \DI\autowire(AuthorSqlRepositoryImplementation::class),
    AuthorDomainServiceInterface::class => \DI\autowire(AuthorServiceImplementation::class),
    AuthorInfrastructureServiceInterface::class => \DI\autowire(AuthorServiceImplementation::class),
    BookRepositoryInterface::class => \DI\autowire(BookSqlRepositoryImplementation::class),
    BookServiceInterface::class => \DI\autowire(BookServiceImplementation::class),
];