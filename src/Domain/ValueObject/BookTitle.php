<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Override;

readonly class BookTitle extends AbstractValueObject
{
    protected function __construct(protected string $title)
    {
        parent::__construct($this->title);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    #[Override] public function get(): string
    {
        return $this->title;
    }
}
