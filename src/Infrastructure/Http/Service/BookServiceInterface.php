<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Service;

interface BookServiceInterface
{
    /**
     * @param string[] $id
     * @return bool
     */
    public function exists(string|array $id): bool;
}
