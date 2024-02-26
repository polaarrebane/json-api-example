<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Service;

use Override;

class AuthorServiceStub implements AuthorServiceInterface
{
    /**
     * @inheritDoc
     */
    #[Override] public function exists(array $ids): bool
    {
        return true;
    }
}
