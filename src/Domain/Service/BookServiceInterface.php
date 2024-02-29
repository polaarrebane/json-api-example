<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Application\Command\DestroyBook;
use Ecotone\Modelling\Attribute\CommandHandler;

interface BookServiceInterface
{
    #[CommandHandler]
    public function handleDestroy(DestroyBook $command): void;
}
