<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class GenreDescription extends AbstractValueObject
{
    protected function __construct(protected string $genreDescription)
    {
        parent::__construct($this->genreDescription);
    }

    public static function fromEnum(GenreEnum $value): self
    {
        return new self($value->description());
    }

    public static function fromAbbreviation(GenreAbbreviation $genreAbbreviation): self
    {
        return new self(GenreEnum::from($genreAbbreviation->get())->description());
    }

    public function get(): string
    {
        return $this->genreDescription;
    }
}
