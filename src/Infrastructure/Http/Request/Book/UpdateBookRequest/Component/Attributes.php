<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\UpdateBookRequest\Component;

final readonly class Attributes
{
    public function __construct(
        /** @var null|non-empty-string */
        public ?string $title = null,
        /** @var null|non-empty-string */
        public ?string $description = null,
        /** @var null|non-empty-string */
        public ?string $cover = null,
        /** @var null|non-empty-list<string> */
        public ?array $tags = null,
    ) {
    }
}
