<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\UpdateAuthorRequest\Component;

final readonly class Attributes
{
    public function __construct(
        /** @var null|non-empty-string */
        public ?string $name = null,
    ) {
    }
}
