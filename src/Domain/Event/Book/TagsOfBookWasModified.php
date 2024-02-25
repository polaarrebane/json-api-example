<?php

declare(strict_types=1);

namespace App\Domain\Event\Book;

use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\TagValue;

readonly class TagsOfBookWasModified
{
    public function __construct(
        protected BookId $bookId,
        /** @var TagValue[] $oldTags */
        protected array $oldTags,
        /** @var TagValue[] $newTags */
        protected array $newTags,
    ) {
    }

    public function getBookId(): BookId
    {
        return $this->bookId;
    }
}
