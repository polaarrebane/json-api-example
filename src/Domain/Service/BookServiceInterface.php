<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Application\Command\DestroyBook;
use App\Application\Query\ListBooks;
use App\Application\Query\RetrieveAuthorsOfBooks;
use App\Application\Query\RetrieveGenresOfBooks;
use App\Domain\Dto\AuthorDto;
use App\Domain\Dto\BookDto;
use App\Domain\Dto\GenreDto;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;

interface BookServiceInterface
{
    #[CommandHandler]
    public function handleDestroy(DestroyBook $command): void;

    /**
     * @param ListBooks $query
     * @return BookDto[]
     */
    #[QueryHandler]
    public function handleList(ListBooks $query): array;

    /**
     * @param RetrieveAuthorsOfBooks $query
     * @return AuthorDto[]
     */
    #[QueryHandler]
    public function handleRetrieveAuthorsOfBooks(RetrieveAuthorsOfBooks $query): array;

    /**
     * @param RetrieveGenresOfBooks $query
     * @return GenreDto[]
     */
    #[QueryHandler]
    public function handleRetrieveGenresOfBooks(RetrieveGenresOfBooks $query): array;
}
