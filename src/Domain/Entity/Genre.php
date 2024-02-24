<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Dto\GenreDto;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreDescription;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\Identifier;

#[Aggregate]
class Genre
{
    public function __construct(
        #[Identifier]
        protected GenreAbbreviation $genreAbbreviation,
        protected GenreDescription $genreDescription,
    ) {
    }

    public function toDto(): GenreDto
    {
        return new GenreDto(
            abbreviation: $this->genreAbbreviation->get(),
            description: $this->genreDescription->get(),
        );
    }

    public function getGenreAbbreviation(): GenreAbbreviation
    {
        return $this->genreAbbreviation;
    }

    public function getGenreDescription(): GenreDescription
    {
        return $this->genreDescription;
    }
}
