<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\ValueObject\AuthorId;

readonly class RetrieveAuthor implements QueryInterface
{
    protected function __construct(
        public AuthorId $authorId,
    ) {
    }

    public static function fromString(string $id): self
    {
        return new self(AuthorId::fromString($id));
    }
}
