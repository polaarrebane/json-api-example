<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\BookId;

readonly class ModifyAttributesOfBook implements CommandInterface
{
    public function __construct(
        public BookId $bookId,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $cover = null,
        /** @var null|string[] */
        public ?array $authors = null,
        /** @var null|string[] */
        public ?array $genres = null,
        /** @var null|string[] */
        public ?array $tags = null,
    ) {
    }
}
