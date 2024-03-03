<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

final readonly class Relationship
{
    public function __construct(
        /** @var RelationshipItem[] $data */
        public array $data,
    ) {
    }
}
