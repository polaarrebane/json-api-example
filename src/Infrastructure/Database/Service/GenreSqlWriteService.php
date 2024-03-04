<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Service;

use App\Domain\Entity\Genre as GenreDomainEntity;
use App\Infrastructure\Database\Entity\Genre as GenreDbEntity;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use DI\Container;

class GenreSqlWriteService
{
    public function __construct(
        protected Container $container,
    ) {
    }

    public function persist(GenreDomainEntity $genreDomainEntity): void
    {
        $orm = $this->container->make(ORM::class);
        $em = new EntityManager($orm);

        /** @var ?GenreDbEntity $genreDbEntity */
        $genreDbEntity = $orm
            ->getRepository(GenreDbEntity::class)
            ->select()
            ->where('abbreviation', $genreDomainEntity->getGenreAbbreviation()->get())
            ->fetchOne();

        if (is_null($genreDbEntity)) {
            $genreDbEntity = new GenreDbEntity(
                abbreviation: $genreDomainEntity->getGenreAbbreviation()->get(),
                description: $genreDomainEntity->getGenreDescription()->get(),
            );
        } else {
            $genreDbEntity->setDescription($genreDomainEntity->getGenreDescription()->get());
        }

        $em->persist($genreDbEntity)->run();
    }
}
