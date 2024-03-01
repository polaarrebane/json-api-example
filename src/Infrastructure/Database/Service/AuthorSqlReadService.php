<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Service;

use App\Domain\Entity\Author as AuthorDomainEntity;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\AuthorName;
use App\Infrastructure\Database\Entity\Author as AuthorDbEntity;
use Cycle\ORM\ORM;

class AuthorSqlReadService
{
    public function __construct(
        protected \DI\Container $container,
    ) {
    }

    public function findBy(AuthorId $authorId): AuthorDomainEntity
    {
        $orm = $this->container->make(ORM::class);

        /** @var null|AuthorDbEntity $authorDbEntity */
        $authorDbEntity = $orm
            ->getRepository(AuthorDbEntity::class)
            ->findByPK($authorId->toUuid());

        if (is_null($authorDbEntity)) {
            throw new \InvalidArgumentException();
        }

        return new AuthorDomainEntity(
            authorId: $authorId,
            authorName: AuthorName::fromString($authorDbEntity->getName()),
        );
    }
}
