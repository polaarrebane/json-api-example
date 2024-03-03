<?php

declare(strict_types=1);

namespace App\Infrastructure\ServiceImplementation;

use App\Application\Query\ListGenres;
use App\Domain\Dto\GenreDto;
use App\Domain\Service\GenreServiceInterface;
use App\Infrastructure\Database\Entity\Genre;
use Cycle\ORM\ORM;
use DI\Container;
use Override;

class GenreServiceImplementation implements GenreServiceInterface
{
    public function __construct(
        protected Container $container,
    ) {
    }

    #[Override] public function handleList(ListGenres $query): array
    {
        $orm = $this->container->make(ORM::class);

        $genres = $orm
            ->getRepository(Genre::class)
            ->select()
            ->fetchAll();

        return array_map(
            static fn(Genre $genre) => new GenreDto(
                abbreviation: $genre->getAbbreviation(),
                description: $genre->getDescription()
            ),
            $genres
        );
    }
}
