<?php

declare(strict_types=1);

namespace App\Domain\Event\Book;

use App\Domain\ValueObject\BookCover;
use App\Domain\ValueObject\BookId;

readonly class CoverOfBookWasModified
{
    public function __construct(
        protected BookId $bookId,
        protected BookCover $oldCover,
        protected BookCover $newCover,
    ) {
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
