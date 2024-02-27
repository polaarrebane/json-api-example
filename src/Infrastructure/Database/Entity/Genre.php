<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Table\Index;

#[Entity]
#[Index(columns: ['abbreviation'], unique: true)]
class Genre
{
    #[Column(type: 'primary')]
    private int $id;

    #[Column(type: 'string')]
    private string $abbreviation;

    #[Column(type: 'string')]
    private string $description;

    /**
     * @param string $abbreviation
     * @param string $description
     */
    public function __construct(string $abbreviation, string $description)
    {
        $this->abbreviation = $abbreviation;
        $this->description = $description;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
