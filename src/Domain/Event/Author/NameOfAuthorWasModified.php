<?php

declare(strict_types=1);

namespace App\Domain\Event\Author;

use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\AuthorName;

readonly class NameOfAuthorWasModified
{
    public function __construct(
        protected AuthorId $authorId,
        protected AuthorName $oldName,
        protected AuthorName $newName,
    ) {
    }

    public function getAuthorId(): AuthorId
    {
        return $this->authorId;
    }
}
