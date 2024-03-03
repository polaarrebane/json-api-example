<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\BookId;

readonly class DestroyBook implements CommandInterface
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
