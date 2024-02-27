<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity]
class BookGenre
{
    #[Column(type: 'primary')]
    private int $id;
}
