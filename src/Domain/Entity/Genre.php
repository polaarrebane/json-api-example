<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Application\Command\AddNewGenre;
use App\Application\Query\RetrieveGenre;
use App\Domain\Dto\GenreDto;
use App\Domain\Event\Genre\GenreWasCreated;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreDescription;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\Identifier;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\WithEvents;

#[Aggregate]
class Genre
{
    use WithEvents;

    public function __construct(
        #[Identifier]
        protected GenreAbbreviation $genreAbbreviation,
        protected GenreDescription $genreDescription,
    ) {
        $this->recordThat(new GenreWasCreated($this->genreAbbreviation));
    }

    public function toDto(): GenreDto
    {
        return new GenreDto(
            abbreviation: $this->genreAbbreviation->get(),
            description: $this->genreDescription->get(),
        );
    }

    #[CommandHandler]
    public static function add(AddNewGenre $command): self
    {
        $abbreviation = GenreAbbreviation::fromString($command->abbreviation);

        return new self($abbreviation, GenreDescription::fromAbbreviation($abbreviation));
    }

    #[QueryHandler]
    public function retrieveGenre(RetrieveGenre $query): GenreDto
    {
        return $this->toDto();
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
