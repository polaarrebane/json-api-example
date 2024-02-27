<?php

declare(strict_types=1);

namespace App\Infrastructure\RepositoryImplementation;

use App\Domain\Entity\Book;
use App\Domain\Repository\BookRepositoryInterface;
use App\Domain\ValueObject\BookId;
use App\Infrastructure\Database\Service\BookSqlReadService;
use App\Infrastructure\Database\Service\BookSqlWriteService;

class BookSqlRepositoryImplementation implements BookRepositoryInterface
{
    public function __construct(
        protected BookSqlReadService $bookSqlReadService,
        protected BookSqlWriteService $bookSqlWriteService,
    ) {
    }

    /**
     * @param string $aggregateClassName
     * @return bool
     */
    public function canHandle(string $aggregateClassName): bool
    {
        return $aggregateClassName === Book::class;
    }

    /**
     * @param string $aggregateClassName
     * @param array<string,string> $identifiers
     * @return Book|null
     */
    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        return $this->bookSqlReadService->findBy(BookId::fromString($identifiers["bookId"]));
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
        if (get_class($aggregate) === Book::class) {
            $this->bookSqlWriteService->persist($aggregate);
        }
    }
}
