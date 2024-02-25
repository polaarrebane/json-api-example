<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Application\Command\AddNewAuthor;
use App\Application\Command\ModifyAttributesOfAuthor;
use App\Domain\Dto\AuthorDto;
use App\Domain\Event\Author\AuthorWasCreated;
use App\Domain\Event\Author\NameOfAuthorWasModified;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\AuthorName;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\CommandHandler;
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
        $this->recordThat(new AuthorWasCreated($this->authorId));
    }

    public function toDto(): AuthorDto
    {
        return new AuthorDto(
            id: $this->authorId->get(),
            name: $this->authorName->get(),
        );
    }

    #[CommandHandler]
    public static function add(AddNewAuthor $command): self
    {
        return new self(AuthorId::fromUuid(), AuthorName::fromString($command->name));
    }

    #[CommandHandler]
    public function modify(ModifyAttributesOfAuthor $command): self
    {
        if ($command->name) {
            $this->updateName($command->name);
        }

        return $this;
    }

    public function getAuthorId(): AuthorId
    {
        return $this->authorId;
    }

    public function getAuthorName(): AuthorName
    {
        return $this->authorName;
    }

    protected function updateName(string $name): void
    {
        $oldName = $this->authorName;
        $newName = AuthorName::fromString($name);
        $this->authorName = $newName;

        $this->recordThat(new NameOfAuthorWasModified(
            authorId: $this->authorId,
            oldName: $oldName,
            newName: $newName
        ));
    }
}
