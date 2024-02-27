<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Table\Index;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid4;

#[Entity]
#[Index(columns: ['value'], unique: true)]
class Tag
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string')]
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
