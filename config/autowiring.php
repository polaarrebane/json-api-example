<?php

declare(strict_types=1);

use App\Domain\Repository\BookRepositoryInterface;
use App\Infrastructure\Http\Service\AuthorServiceInterface;
use App\Infrastructure\Http\Service\AuthorServiceStub;
use App\Infrastructure\RepositoryImplementation\BookSqlRepositoryImplementation;

return [
    AuthorServiceInterface::class => \DI\autowire(AuthorServiceStub::class),
    BookRepositoryInterface::class => \DI\autowire(BookSqlRepositoryImplementation::class),
];