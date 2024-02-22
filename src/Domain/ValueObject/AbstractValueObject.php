<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Override;

abstract readonly class AbstractValueObject implements ValueObjectInterface
{
    protected function __construct(protected mixed $value)
    {
    }

    #[Override] public function get(): mixed
    {
        return $this->value;
    }

    #[Override] public function isEqualTo(ValueObjectInterface $valueObject): bool
    {
        return $this->value === $valueObject->get();
    }
}
