<?php

declare(strict_types=1);

namespace App\Domain\Event\Genre;

use App\Domain\ValueObject\GenreAbbreviation;

readonly class GenreWasCreated
{
    public function __construct(protected GenreAbbreviation $genreAbbreviation)
    {
    }

    public function getGenreAbbreviation(): GenreAbbreviation
    {
        return $this->genreAbbreviation;
    }
}
