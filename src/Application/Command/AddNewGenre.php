<?php

declare(strict_types=1);

namespace App\Application\Command;

readonly class AddNewGenre implements CommandInterface
{
    public function __construct(
        public string $abbreviation,
    ) {
    }
}
