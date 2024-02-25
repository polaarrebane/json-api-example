<?php

declare(strict_types=1);

namespace App\Domain\Dto;

readonly class BookDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $cover,
        /** @var string[] $authors */
        public array $authors,
        /** @var string[] $genres */
        public array $genres,
        /** @var string[] $tags */
        public array $tags,
    ) {
    }
}
