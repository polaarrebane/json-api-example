<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Service;

interface AuthorServiceInterface
{
    /**
     * @param string[] $ids
     * @return bool
     */
    public function exists(array $ids): bool;
}
