<?php

declare(strict_types=1);

namespace App\Application\Query;

readonly class ListBooks implements QueryInterface
{
    public static function all(): self
    {
        return new self();
    }
}
