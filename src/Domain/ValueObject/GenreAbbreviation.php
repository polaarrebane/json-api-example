<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class GenreAbbreviation extends AbstractValueObject
{
    protected function __construct(protected GenreEnum $genreEnum)
    {
        parent::__construct($this->genreEnum);
    }

    public static function fromString(string $value): self
    {
        return new self(GenreEnum::from($value));
    }

    public static function fromEnum(GenreEnum $value): self
    {
        return new self($value);
    }

    public function get(): string
    {
        return $this->genreEnum->value;
    }

    public function isEqualTo(self|ValueObjectInterface $valueObject): bool
    {
        return ($valueObject::class === self::class) && ($this->genreEnum === $valueObject->genreEnum);
    }

    public function __toString(): string
    {
        return $this->genreEnum->value;
    }
}
