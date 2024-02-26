<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class TagValue extends AbstractValueObject
{
    protected function __construct(protected string $tag)
    {
        parent::__construct($this->tag);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    #[\Override] public function get(): string
    {
        return $this->tag;
    }
}
