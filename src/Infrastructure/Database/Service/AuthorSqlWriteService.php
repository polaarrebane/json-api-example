<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Service;

use App\Domain\Entity\Author as AuthorDomainEntity;
use App\Infrastructure\Database\Entity\Author as AuthorDbEntity;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use DI\Container;

class AuthorSqlWriteService
{
    public function __construct(
        protected Container $container,
    ) {
    }

    public function persist(AuthorDomainEntity $authorDomainEntity): void
    {
        $orm = $this->container->make(ORM::class);
        $em = new EntityManager($orm);

        /** @var ?AuthorDbEntity $authorDbEntity */
        $authorDbEntity = $orm
            ->getRepository(AuthorDbEntity::class)
            ->findByPK($authorDomainEntity->getAuthorId()->toUuid());

        if (is_null($authorDbEntity)) {
            $authorDbEntity = new AuthorDbEntity(
                id: $authorDomainEntity->getAuthorId()->toUuid(),
                name: $authorDomainEntity->getAuthorName()->get(),
            );
        } else {
            $authorDbEntity->setName($authorDomainEntity->getAuthorName()->get());
        }

        $em->persist($authorDbEntity)->run();
    }
}
