<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Application\Command\DestroyAuthor;
use App\Application\Query\ListAuthors;
use App\Domain\Dto\AuthorDto;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;

interface AuthorServiceInterface
{
    #[CommandHandler]
    public function handleDestroy(DestroyAuthor $command): void;

    /**
     * @param ListAuthors $query
     * @return AuthorDto[]
     */
    #[QueryHandler]
    public function handleList(ListAuthors $query): array;
}
