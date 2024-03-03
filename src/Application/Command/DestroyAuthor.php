<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\AuthorId;

readonly class DestroyAuthor implements CommandInterface
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
