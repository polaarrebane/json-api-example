<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\CreateAuthorRequest\Component;

final readonly class Attributes
{
    public function __construct(
        /** @var non-empty-string */
        public string $name,
    ) {
    }
}
