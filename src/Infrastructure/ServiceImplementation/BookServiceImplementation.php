<?php

declare(strict_types=1);

namespace App\Infrastructure\ServiceImplementation;

use App\Application\Command\DestroyBook;
use App\Application\Query\ListBooks;
use App\Domain\Dto\BookDto;
use App\Domain\Service\BookServiceInterface as BookDomainService;
use App\Infrastructure\Database\Entity\Author;
use App\Infrastructure\Database\Entity\Book;
use App\Infrastructure\Database\Entity\Book as BookDbEntity;
use App\Infrastructure\Database\Entity\Genre;
use App\Infrastructure\Database\Entity\Tag;
use App\Infrastructure\Http\Service\BookServiceInterface as BookInfrastructureService;
use Cycle\Database\DatabaseManager;
use Cycle\Database\Injection\Parameter;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use DI\Container;
use Override;

class BookServiceImplementation implements BookDomainService, BookInfrastructureService
{
    public function __construct(
        protected Container $container,
    ) {
    }

    #[Override]
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

    #[Override] public function handleList(ListBooks $query): array
    {
        $orm = $this->container->make(ORM::class);

        $books = $orm
            ->getRepository(BookDbEntity::class)
            ->select()
            ->load('authors')
            ->load('genres')
            ->load('tags')
            ->fetchAll();

        return array_map(
            static fn(Book $book) => new BookDto(
                id: $book->getUuid()->toString(),
                title: $book->getTitle(),
                description: $book->getDescription(),
                cover: $book->getCover(),
                authors: array_map(
                    static fn(Author $author) => $author->getUuid()->toString(),
                    $book->getAuthors()
                ),
                genres: array_map(
                    static fn(Genre $genre) => $genre->getAbbreviation(),
                    $book->getGenres()
                ),
                tags: array_map(
                    static fn(Tag $tag) => $tag->getValue(),
                    $book->getTags()
                ),
            ),
            $books
        );
    }

    #[Override]
    public function exists(string|array $id): bool
    {
        if (is_string($id)) {
            $id = [$id];
        }

        $id = array_unique($id);
        /** @var DatabaseManager $dbal */
        $dbal = $this->container->get(DatabaseManager::class);

        $count = $dbal
            ->database()
            ->table('books')
            ->select()
            ->where(['uuid' => ['in' => new Parameter($id)]])
            ->count();

        return $count === count($id);
    }
}
