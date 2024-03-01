<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Application\Command\DestroyAuthor;
use Ecotone\Modelling\Attribute\CommandHandler;

interface AuthorServiceInterface
{
    #[CommandHandler]
    public function handleDestroy(DestroyAuthor $command): void;
}
