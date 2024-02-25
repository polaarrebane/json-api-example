<?php

declare(strict_types=1);

namespace App\Application\Command;

readonly class AddNewAuthor
{
    public function __construct(
        public string $name,
    ) {
    }
}
