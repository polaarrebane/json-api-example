<?php

declare(strict_types=1);

namespace App\Domain\Event\Book;

use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\BookTitle;

class TitleOfBookWasModified
{
    public function __construct(
        protected BookId $bookId,
        protected BookTitle $oldTitle,
        protected BookTitle $newTitle,
    ) {
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
