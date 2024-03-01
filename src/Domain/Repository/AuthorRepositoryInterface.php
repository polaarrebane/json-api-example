<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use Ecotone\Modelling\Attribute\Repository;
use Ecotone\Modelling\StandardRepository;

#[Repository]
interface AuthorRepositoryInterface extends StandardRepository
{
}
