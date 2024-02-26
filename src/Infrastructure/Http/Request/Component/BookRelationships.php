<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Component;

final readonly class BookRelationships
{
    public function __construct(
        public Relationship $authors,
        public Relationship $genres,
    ) {
    }
}
