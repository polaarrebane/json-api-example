<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Application\Command\DestroyBook;
use App\Application\Query\ListBooks;
use App\Domain\Dto\BookDto;
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
}
