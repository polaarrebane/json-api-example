<?php

declare(strict_types=1);

namespace App\Infrastructure\RepositoryImplementation;

use App\Domain\Entity\Author;
use App\Domain\Entity\Book;
use App\Domain\Repository\AuthorRepositoryInterface;
use App\Domain\ValueObject\AuthorId;
use App\Infrastructure\Database\Service\AuthorSqlReadService;
use App\Infrastructure\Database\Service\AuthorSqlWriteService;

class AuthorSqlRepositoryImplementation implements AuthorRepositoryInterface
{
    public function __construct(
        protected AuthorSqlReadService $authorSqlReadService,
        protected AuthorSqlWriteService $authorSqlWriteService,
    ) {
    }

    /**
     * @param string $aggregateClassName
     * @return bool
     */
    public function canHandle(string $aggregateClassName): bool
    {
        return $aggregateClassName === Author::class;
    }

    /**
     * @param string $aggregateClassName
     * @param array<string,string> $identifiers
     * @return Author|null
     */
    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        return $this->authorSqlReadService->findBy(AuthorId::fromString($identifiers["authorId"]));
    }

    /**
     * @param array<string,string> $identifiers
     * @param object $aggregate
     * @param array<int|string,mixed> $metadata
     * @param int|null $versionBeforeHandling
     * @return void
     */
    public function save(array $identifiers, object $aggregate, array $metadata, ?int $versionBeforeHandling): void
    {
        if (get_class($aggregate) === Author::class) {
            $this->authorSqlWriteService->persist($aggregate);
        }
    }
}
