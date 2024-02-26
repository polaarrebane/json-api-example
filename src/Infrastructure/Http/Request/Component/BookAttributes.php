<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Component;

final readonly class BookAttributes
{
    public function __construct(
        /** @var non-empty-string */
        public string $title,
        /** @var non-empty-string */
        public string $description,
        /** @var non-empty-string */
        public string $cover,
        /** @var non-empty-list<string> */
        public array $tags,
    ) {
    }
}
