<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Dto\BookDto;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\BookCover;
use App\Domain\ValueObject\BookDescription;
use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\BookTitle;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\TagValue;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\Identifier;
use Ecotone\Modelling\WithEvents;

#[Aggregate]
class Book
{
    use WithEvents;

    public function __construct(
        #[Identifier]
        protected BookId $bookId,
        protected BookTitle $title,
        protected BookDescription $description,
        protected BookCover $cover,
        /** @var AuthorId[] $authors */
        protected array $authors = [],
        /** @var GenreAbbreviation[] $genres */
        protected array $genres = [],
        /** @var TagValue[] $tags */
        protected array $tags = [],
    ) {
    }

    public function toDto(): BookDto
    {
        return new BookDto(
            id: $this->bookId->get(),
            title: $this->title->get(),
            description: $this->description->get(),
            cover: $this->description->get(),
            authors: array_map(static fn(AuthorId $authorId) => $authorId->get(), $this->authors),
            genres: array_map(static fn(GenreAbbreviation $genreAbbreviation) => $genreAbbreviation->get(), $this->genres),
            tags: array_map(static fn(TagValue $tagValue) => $tagValue->get(), $this->tags),
        );
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }

    public function getTitle(): BookTitle
    {
        return $this->title;
    }

    public function getDescription(): BookDescription
    {
        return $this->description;
    }

    public function getCover(): BookCover
    {
        return $this->cover;
    }

    /**
     * @return AuthorId[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @return GenreAbbreviation[]
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @return TagValue[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
