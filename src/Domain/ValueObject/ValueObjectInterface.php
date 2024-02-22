<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

interface ValueObjectInterface
{
    public function get(): mixed;

    public function isEqualTo(self $valueObject): bool;
}
