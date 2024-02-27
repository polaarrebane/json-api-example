<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid4;
use Ramsey\Uuid\UuidInterface;

#[Entity]
#[Uuid4]
class Author
{
    #[Column(type: 'uuid', primary: true, field: 'id')]
    private UuidInterface $uuid;

    #[Column(type: 'string')]
    private string $name;

    /**
     * @param UuidInterface $id
     * @param string $name
     */
    public function __construct(UuidInterface $id, string $name)
    {
        $this->uuid = $id;
        $this->name = $name;
    }


    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
