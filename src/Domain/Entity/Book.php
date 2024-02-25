<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Application\Command\AddNewBook;
use App\Application\Command\ModifyAttributesOfBook;
use App\Domain\Dto\BookDto;
use App\Domain\Event\Book\AuthorsOfBookWasModified;
use App\Domain\Event\Book\BookWasCreated;
use App\Domain\Event\Book\CoverOfBookWasModified;
use App\Domain\Event\Book\DescriptionOfBookWasModified;
use App\Domain\Event\Book\GenresOfBookWasModified;
use App\Domain\Event\Book\TagsOfBookWasModified;
use App\Domain\Event\Book\TitleOfBookWasModified;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\BookCover;
use App\Domain\ValueObject\BookDescription;
use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\BookTitle;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\TagValue;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\CommandHandler;
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
        $this->recordThat(new BookWasCreated($this->bookId));
    }

    public function toDto(): BookDto
    {
        return new BookDto(
            id: $this->bookId->get(),
            title: $this->title->get(),
            description: $this->description->get(),
            cover: $this->cover->get(),
            authors: array_map(static fn(AuthorId $authorId) => $authorId->get(), $this->authors),
            genres: array_map(static fn(GenreAbbreviation $genreAbbreviation) => $genreAbbreviation->get(), $this->genres),
            tags: array_map(static fn(TagValue $tagValue) => $tagValue->get(), $this->tags),
        );
    }

    #[CommandHandler]
    public static function add(AddNewBook $command): self
    {
        return new self(
            bookId: BookId::fromUuid(),
            title: BookTitle::fromString($command->title),
            description: BookDescription::fromString($command->description),
            cover: BookCover::fromString($command->cover),
            authors: array_map(
                static fn(string $authorId) => AuthorId::fromString($authorId),
                $command->authors
            ),
            genres: array_map(
                static fn(string $genreAbbreviation) => GenreAbbreviation::fromString($genreAbbreviation),
                $command->genres
            ),
            tags: array_map(
                static fn(string $tagValue) => TagValue::fromString($tagValue),
                $command->tags
            ),
        );
    }

    #[CommandHandler]
    public function modify(ModifyAttributesOfBook $command): self
    {
        if ($command->title) {
            $this->updateTitle($command->title);
        }

        if ($command->description) {
            $this->updateDescription($command->description);
        }

        if ($command->cover) {
            $this->updateCover($command->cover);
        }

        if ($command->authors) {
            $this->updateAuthors($command->authors);
        }

        if ($command->genres) {
            $this->updateGenres($command->genres);
        }

        if ($command->tags) {
            $this->updateTags($command->tags);
        }

        return $this;
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

    protected function updateTitle(string $title): void
    {
        $oldTitle = $this->title;
        $newTitle = BookTitle::fromString($title);
        $this->title = $newTitle;

        $this->recordThat(new TitleOfBookWasModified(
            bookId: $this->bookId,
            oldTitle: $oldTitle,
            newTitle: $newTitle,
        ));
    }

    protected function updateDescription(string $description): void
    {
        $oldDescription = $this->description;
        $newDescription = BookDescription::fromString($description);
        $this->description = $newDescription;

        $this->recordThat(new DescriptionOfBookWasModified(
            bookId: $this->bookId,
            oldDescription: $oldDescription,
            newDescription: $newDescription,
        ));
    }

    protected function updateCover(string $cover): void
    {
        $oldCover = $this->cover;
        $newCover = BookCover::fromString($cover);
        $this->cover = $newCover;

        $this->recordThat(new CoverOfBookWasModified(
            bookId: $this->bookId,
            oldCover: $oldCover,
            newCover: $newCover,
        ));
    }

    /**
     * @param string[] $authors
     * @return void
     */
    protected function updateAuthors(array $authors): void
    {
        $oldAuthors = $this->authors;
        $newAuthors = array_map(static fn(string $authorId) => AuthorId::fromString($authorId), $authors);
        $this->authors = $newAuthors;

        $this->recordThat(new AuthorsOfBookWasModified(
            bookId: $this->bookId,
            oldAuthors: $oldAuthors,
            newAuthors: $newAuthors,
        ));
    }

    /**
     * @param string[] $genres
     * @return void
     */
    protected function updateGenres(array $genres): void
    {
        $oldGenres = $this->genres;
        $newGenres = array_map(static fn(string $genreAbbreviation) => GenreAbbreviation::fromString($genreAbbreviation), $genres);
        $this->genres = $newGenres;

        $this->recordThat(new GenresOfBookWasModified(
            bookId: $this->bookId,
            oldGenres: $oldGenres,
            newGenres: $newGenres,
        ));
    }

    /**
     * @param string[] $tags
     * @return void
     */
    protected function updateTags(array $tags): void
    {
        $oldTags = $this->tags;
        $newTags = array_map(
            static fn(string $tagValue) => TagValue::fromString($tagValue),
            $tags
        );
        $this->tags = $newTags;

        $this->recordThat(new TagsOfBookWasModified(
            bookId: $this->bookId,
            oldTags: $oldTags,
            newTags: $newTags,
        ));
    }
}
