<?php

declare(strict_types=1);

namespace App\Domain\Event\Book;

use App\Domain\ValueObject\BookId;

readonly class BookWasCreated
{
    public function __construct(protected BookId $bookId)
    {
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
