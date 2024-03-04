<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\DeleteBookRequest;

use App\Application\Command\CommandInterface;
use App\Application\Command\DestroyBook;
use App\Infrastructure\Http\Request\Book\BookRequest;
use Override;

final class DeleteBookRequest extends BookRequest
{
    protected string $resourceId;

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    #[Override]
    public function toBusRequest(): CommandInterface
    {
        return DestroyBook::fromString($this->resourceId);
    }

    protected function validate(): void
    {
        $this->requestValidator->validateBookId($this->resourceId);
    }
}
