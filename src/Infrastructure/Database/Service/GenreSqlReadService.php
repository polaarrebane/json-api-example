<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Service;

use App\Domain\Entity\Genre as GenreDomainEntity;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreDescription;
use App\Infrastructure\Database\Entity\Genre as GenreDbEntity;
use Cycle\ORM\ORM;
use DI\Container;
use InvalidArgumentException;

class GenreSqlReadService
{
    public function __construct(
        protected Container $container,
    ) {
    }

    public function findBy(GenreAbbreviation $genreAbbreviation): GenreDomainEntity
    {
        $orm = $this->container->make(ORM::class);

        /** @var null|GenreDbEntity $genreDbEntity */
        $genreDbEntity = $orm
            ->getRepository(GenreDbEntity::class)
            ->select()
            ->where('abbreviation', $genreAbbreviation->get())
            ->fetchOne();

        if (is_null($genreDbEntity)) {
            throw new InvalidArgumentException();
        }

        $abbreviation = GenreAbbreviation::fromString($genreDbEntity->getAbbreviation());

        return new GenreDomainEntity(
            genreAbbreviation: $abbreviation,
            genreDescription: GenreDescription::fromAbbreviation($abbreviation),
        );
    }
}
