<?php

declare(strict_types=1);

namespace App\Domain\Event\Book;

use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\GenreAbbreviation;

readonly class GenresOfBookWasModified
{
    public function __construct(
        protected BookId $bookId,
        /** @var GenreAbbreviation[] $oldGenres */
        protected array $oldGenres,
        /** @var GenreAbbreviation[] $newGenres */
        protected array $newGenres,
    ) {
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
