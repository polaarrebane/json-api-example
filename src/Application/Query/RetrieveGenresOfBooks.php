<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\ValueObject\BookId;

readonly class RetrieveGenresOfBooks implements QueryInterface
{
    /**
     * @param BookId[] $bookIds
     */
    protected function __construct(
        public array $bookIds,
    ) {
    }

    /**
     * @param string[] $ids
     * @return self
     */
    public static function fromArrayOfString(array $ids): self
    {
        return new self(array_map(static fn(string $id) => BookId::fromString($id), $ids));
    }
}
