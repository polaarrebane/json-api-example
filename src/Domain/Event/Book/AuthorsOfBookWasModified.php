<?php

declare(strict_types=1);

namespace App\Domain\Event\Book;

use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\BookId;

readonly class AuthorsOfBookWasModified
{
    public function __construct(
        protected BookId $bookId,
        /** @var AuthorId[] $oldAuthors */
        protected array $oldAuthors,
        /** @var AuthorId[] $newAuthors */
        protected array $newAuthors,
    ) {
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
