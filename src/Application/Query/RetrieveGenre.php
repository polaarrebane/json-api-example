<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\ValueObject\GenreAbbreviation;

readonly class RetrieveGenre implements QueryInterface
{
    protected function __construct(
        public GenreAbbreviation $genreAbbreviation,
    ) {
    }

    public static function fromString(string $id): self
    {
        return new self(GenreAbbreviation::fromString($id));
    }
}
