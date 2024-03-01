<?php

declare(strict_types=1);

namespace App\Infrastructure\ServiceImplementation;

use App\Application\Command\DestroyBook;
use App\Domain\Service\BookServiceInterface;
use App\Infrastructure\Database\Entity\Book;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;

class BookServiceImplementation implements BookServiceInterface
{
    public function __construct(
        protected \DI\Container $container,
    ) {
    }

    #[\Override]
    public function handleDestroy(DestroyBook $command): void
    {
        $orm = $this->container->make(ORM::class);
        $book = $orm->getRepository(Book::class)->findByPK($command->bookId->get());

        if ($book) {
            $em = new EntityManager($orm);
            $em->delete($book);
            $em->run();
        }
    }
}
