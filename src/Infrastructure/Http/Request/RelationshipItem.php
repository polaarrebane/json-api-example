<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

final readonly class RelationshipItem
{
    public function __construct(
        /** @var non-empty-string */
        public string $type,
        /** @var non-empty-string */
        public string $id,
    ) {
    }
}
