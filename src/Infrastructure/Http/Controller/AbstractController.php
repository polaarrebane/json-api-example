<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use DI\Attribute\Inject;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;

abstract class AbstractController
{
    #[Inject]
    protected CommandBus $commandBus;

    #[Inject]
    protected QueryBus $queryBus;
}
