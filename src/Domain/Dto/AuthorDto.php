<?php

declare(strict_types=1);

namespace App\Domain\Dto;

readonly class AuthorDto
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
