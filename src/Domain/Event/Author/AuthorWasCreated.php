<?php

declare(strict_types=1);

namespace App\Domain\Event\Author;

use App\Domain\ValueObject\AuthorId;

readonly class AuthorWasCreated
{
    public function __construct(protected AuthorId $authorId)
    {
    }

    public function getAuthorId(): AuthorId
    {
        return $this->authorId;
    }
}
