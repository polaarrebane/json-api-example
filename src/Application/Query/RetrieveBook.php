<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\ValueObject\BookId;

readonly class RetrieveBook implements QueryInterface
{
    protected function __construct(
        public BookId $bookId,
    ) {
    }

    public static function fromString(string $id): self
    {
        return new self(BookId::fromString($id));
    }
}
