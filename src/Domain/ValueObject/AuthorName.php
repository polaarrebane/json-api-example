<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Override;

readonly class AuthorName extends AbstractValueObject
{
    protected function __construct(protected string $name)
    {
        parent::__construct($this->name);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    #[Override] public function get(): string
    {
        return $this->name;
    }
}
