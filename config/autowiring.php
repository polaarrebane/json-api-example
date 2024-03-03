<?php

declare(strict_types=1);

use App\Domain\Repository\AuthorRepositoryInterface;
use App\Domain\Repository\BookRepositoryInterface;
use App\Domain\Service\AuthorServiceInterface as AuthorDomainServiceInterface;
use App\Domain\Service\BookServiceInterface as BookDomainServiceInterface;
use App\Domain\Service\GenreServiceInterface as GenreDomainServiceInterface;
use App\Infrastructure\Http\Service\AuthorServiceInterface as AuthorInfrastructureServiceInterface;
use App\Infrastructure\Http\Service\BookServiceInterface as BookInfrastructureServiceInterface;
use App\Infrastructure\RepositoryImplementation\AuthorSqlRepositoryImplementation;
use App\Infrastructure\RepositoryImplementation\BookSqlRepositoryImplementation;
use App\Infrastructure\ServiceImplementation\AuthorServiceImplementation;
use App\Infrastructure\ServiceImplementation\BookServiceImplementation;
use App\Infrastructure\ServiceImplementation\GenreServiceImplementation;

return [
    AuthorRepositoryInterface::class => \DI\autowire(AuthorSqlRepositoryImplementation::class),
    AuthorDomainServiceInterface::class => \DI\autowire(AuthorServiceImplementation::class),
    AuthorInfrastructureServiceInterface::class => \DI\autowire(AuthorServiceImplementation::class),
    BookRepositoryInterface::class => \DI\autowire(BookSqlRepositoryImplementation::class),
    BookDomainServiceInterface::class => \DI\autowire(BookServiceImplementation::class),
    BookInfrastructureServiceInterface::class => \DI\autowire(BookServiceImplementation::class),
    GenreDomainServiceInterface::class => \DI\autowire(GenreServiceImplementation::class),
];