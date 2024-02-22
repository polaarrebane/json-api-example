<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class BookDescription extends AbstractValueObject
{
    protected function __construct(protected string $description)
    {
        parent::__construct($this->description);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function get(): string
    {
        return $this->description;
    }
}
