<?php

declare(strict_types=1);

namespace App\Infrastructure\ServiceImplementation;

use App\Application\Command\DestroyAuthor;
use App\Domain\Service\AuthorServiceInterface as AuthorDomainServiceInterface;
use App\Infrastructure\Http\Service\AuthorServiceInterface as AuthorInfrastructureServiceInterface;
use App\Infrastructure\Database\Entity\Author;
use Cycle\Database\DatabaseManager;
use Cycle\Database\Injection\Parameter;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;

class AuthorServiceImplementation implements AuthorDomainServiceInterface, AuthorInfrastructureServiceInterface
{
    public function __construct(
        protected \DI\Container $container,
    ) {
    }

    #[\Override]
    public function handleDestroy(DestroyAuthor $command): void
    {
        $orm = $this->container->make(ORM::class);
        $author = $orm->getRepository(Author::class)->findByPK($command->authorId->get());
        if ($author) {
            $em = new EntityManager($orm);
            $em->delete($author);
            $em->run();
        }
    }

    #[\Override]
    public function exists(array $ids): bool
    {
        $ids = array_unique($ids);
        /** @var DatabaseManager $dbal */
        $dbal = $this->container->get(DatabaseManager::class);

        $count = $dbal
            ->database()
            ->table('authors')
            ->select()
            ->where(['uuid' => ['in' => new Parameter($ids)]])
            ->count();

        return $count === count($ids);
    }
}
