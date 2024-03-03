<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Application\Query\ListGenres;
use App\Domain\Dto\GenreDto;
use Ecotone\Modelling\Attribute\QueryHandler;

interface GenreServiceInterface
{
    /**
     * @param ListGenres $query
     * @return GenreDto[]
     */
    #[QueryHandler]
    public function handleList(ListGenres $query): array;
}
