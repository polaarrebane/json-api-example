<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Override;

readonly class BookCover extends AbstractValueObject
{
    protected function __construct(protected string $cover)
    {
        parent::__construct($this->cover);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    #[Override] public function get(): string
    {
        return $this->cover;
    }
}
