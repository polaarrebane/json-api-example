<?php

declare(strict_types=1);

namespace App\Infrastructure\RepositoryImplementation;

use App\Domain\Entity\Genre;
use App\Domain\Repository\GenreRepositoryInterface;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Infrastructure\Database\Service\GenreSqlReadService;
use App\Infrastructure\Database\Service\GenreSqlWriteService;

class GenreSqlRepositoryImplementation implements GenreRepositoryInterface
{
    public function __construct(
        protected GenreSqlReadService $genreSqlReadService,
        protected GenreSqlWriteService $genreSqlWriteService,
    ) {
    }

    /**
     * @param string $aggregateClassName
     * @return bool
     */
    public function canHandle(string $aggregateClassName): bool
    {
        return $aggregateClassName === Genre::class;
    }

    /**
     * @param string $aggregateClassName
     * @param array<string,string> $identifiers
     * @return Genre|null
     */
    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        return $this->genreSqlReadService->findBy(GenreAbbreviation::fromString($identifiers["genreAbbreviation"]));
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
        if (get_class($aggregate) === Genre::class) {
            $this->genreSqlWriteService->persist($aggregate);
        }
    }
}
