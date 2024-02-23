<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Dto\AuthorDto;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\AuthorName;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\Identifier;
use Ecotone\Modelling\WithEvents;

#[Aggregate]
class Author
{
    use WithEvents;

    public function __construct(
        #[Identifier]
        protected AuthorId $authorId,
        protected AuthorName $authorName,
    ) {
    }

    public function toDto(): AuthorDto
    {
        return new AuthorDto(
            id: $this->authorId->get(),
            name: $this->authorName->get(),
        );
    }

    public function getAuthorId(): AuthorId
    {
        return $this->authorId;
    }

    public function getAuthorName(): AuthorName
    {
        return $this->authorName;
    }
}
