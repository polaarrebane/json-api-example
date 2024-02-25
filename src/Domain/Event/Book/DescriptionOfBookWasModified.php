<?php

declare(strict_types=1);

namespace App\Domain\Event\Book;

use App\Domain\ValueObject\BookDescription;
use App\Domain\ValueObject\BookId;

readonly class DescriptionOfBookWasModified
{
    public function __construct(
        protected BookId $bookId,
        protected BookDescription $oldDescription,
        protected BookDescription $newDescription,
    ) {
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
