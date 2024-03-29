<?php

declare(strict_types=1);

namespace App\Domain\Dto;

readonly class GenreDto implements DtoInterface
{
    public function __construct(
        public string $abbreviation,
        public string $description,
    ) {
    }
}
