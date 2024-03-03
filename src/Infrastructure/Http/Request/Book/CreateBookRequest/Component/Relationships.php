<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\CreateBookRequest\Component;

use App\Infrastructure\Http\Request\Relationship;

final readonly class Relationships
{
    public function __construct(
        public Relationship $authors,
        public Relationship $genres,
    ) {
    }
}
