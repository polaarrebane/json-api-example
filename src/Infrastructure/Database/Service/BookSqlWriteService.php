<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Service;

use App\Domain\Entity\Book as BookDomainEntity;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\TagValue;
use App\Infrastructure\Database\Entity\Author;
use App\Infrastructure\Database\Entity\Genre;
use App\Infrastructure\Database\Entity\Tag;
use Cycle\Database\Injection\Parameter;
use Cycle\ORM\EntityManager;
use App\Infrastructure\Database\Entity\Book as BookDbEntity;
use Cycle\ORM\ORM;

class BookSqlWriteService
{
    public function __construct(
        protected \DI\Container $container,
    ) {
    }

    public function persist(BookDomainEntity $bookDomainEntity): void
    {
        $orm = $this->container->make(ORM::class);
        $em = new EntityManager($orm);

        /** @var ?BookDbEntity $bookDbEntity */
        $bookDbEntity = $orm
            ->getRepository(BookDbEntity::class)
            ->findByPK($bookDomainEntity->getBookId()->toUuid());

        if (is_null($bookDbEntity)) {
            $bookDbEntity = new BookDbEntity(
                id: $bookDomainEntity->getBookId()->toUuid(),
                title: $bookDomainEntity->getTitle()->get(),
                description: $bookDomainEntity->getDescription()->get(),
                cover: $bookDomainEntity->getCover()->get(),
            );
        } else {
            $bookDbEntity->setTitle($bookDomainEntity->getTitle()->get());
            $bookDbEntity->setDescription($bookDomainEntity->getDescription()->get());
            $bookDbEntity->setCover($bookDomainEntity->getCover()->get());
        }

        $authorIds = array_map(
            static fn(AuthorId $authorId) => $authorId->get(),
            $bookDomainEntity->getAuthors()
        );

        $genreAbbreviations = array_map(
            static fn(GenreAbbreviation $abbreviation) => $abbreviation->get(),
            $bookDomainEntity->getGenres()
        );

        $tagValues = array_map(
            static fn(TagValue $tagValue) => $tagValue->get(),
            $bookDomainEntity->getTags()
        );

        $authors = $orm->getRepository(Author::class)
            ->select()
            ->where('uuid', 'in', new Parameter($authorIds))
            ->fetchAll();

        $genres = $orm->getRepository(Genre::class)
            ->select()
            ->where('abbreviation', 'in', new Parameter($genreAbbreviations))
            ->fetchAll();

        $tags = $orm->getRepository(Tag::class)
            ->select()
            ->where('value', 'in', new Parameter($tagValues))
            ->fetchAll();

        $tagsNotInDatabase = array_diff(
            $tagValues,
            array_map(static fn(Tag $tag) => $tag->getValue(), $tags)
        );

        foreach ($tagsNotInDatabase as $tagNotInDatabase) {
            $tags[] = new Tag($tagNotInDatabase);
        }

        $bookDbEntity->setAuthors($authors);
        $bookDbEntity->setGenres($genres);
        $bookDbEntity->setTags($tags);

        $em->persist($bookDbEntity)->run();
    }
}
