<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Exception;

use RuntimeException;

class NotFoundException extends RuntimeException
{
    public function __construct(
        protected string $entity,
        protected string $id,
    ) {
        parent::__construct(
            "Entity $entity with id $id is not found"
        );
    }
}
