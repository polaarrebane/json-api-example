<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Service;

use App\Domain\Entity\Book as BookDomainEntity;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\BookCover;
use App\Domain\ValueObject\BookDescription;
use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\BookTitle;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\TagValue;
use App\Infrastructure\Database\Entity\Author;
use App\Infrastructure\Database\Entity\Book as BookDbEntity;
use App\Infrastructure\Database\Entity\Genre;
use App\Infrastructure\Database\Entity\Tag;
use Cycle\ORM\ORM;

class BookSqlReadService
{
    public function __construct(
        protected ORM $orm,
    ) {
    }

    public function findBy(BookId $bookId): BookDomainEntity
    {
        /** @var BookDbEntity $bookDbEntity */
        $bookDbEntity = $this->orm
            ->getRepository(BookDbEntity::class)
//            ->select()
//            ->with('authors')
//            ->with('genres')
//            ->with('tags')
            ->findByPK($bookId->toUuid());

        $authorIds = array_map(
            static fn(Author $authorDbEntity) => AuthorId::fromUuid($authorDbEntity->getUuid()),
            $bookDbEntity->getAuthors()
        );

        $genreAbbreviations = array_map(
            static fn(Genre $genreDbEntity) => GenreAbbreviation::fromString($genreDbEntity->getAbbreviation()),
            $bookDbEntity->getGenres()
        );

        $tags = array_map(
            static fn(Tag $tagDbEntity) => TagValue::fromString($tagDbEntity->getValue()),
            $bookDbEntity->getTags()
        );

        return new BookDomainEntity(
            bookId: $bookId,
            title: BookTitle::fromString($bookDbEntity->getTitle()),
            description: BookDescription::fromString($bookDbEntity->getDescription()),
            cover: BookCover::fromString($bookDbEntity->getCover()),
            authors:  $authorIds,
            genres: $genreAbbreviations,
            tags: $tags,
        );
    }
}
