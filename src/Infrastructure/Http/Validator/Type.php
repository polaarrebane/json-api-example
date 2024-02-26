<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Validator;

enum Type: string
{
    case AUTHORS = "authors";
    case BOOKS = "books";
    case GENRES = "genres";

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(
            static fn(self $type) => $type->value,
            self::cases()
        );
    }
}
