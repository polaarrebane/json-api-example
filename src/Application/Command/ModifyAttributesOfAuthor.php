<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\AuthorId;

readonly class ModifyAttributesOfAuthor
{
    public function __construct(
        public AuthorId $authorId,
        public ?string $name = null,
    ) {
    }
}
