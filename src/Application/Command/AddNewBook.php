<?php

declare(strict_types=1);

namespace App\Application\Command;

readonly class AddNewBook implements CommandInterface
{
    public function __construct(
        public string $title,
        public string $description,
        public string $cover,
        /** @var string[] */
        public array $authors,
        /** @var string[] */
        public array $genres,
        /** @var string[] */
        public array $tags,
    ) {
    }
}
