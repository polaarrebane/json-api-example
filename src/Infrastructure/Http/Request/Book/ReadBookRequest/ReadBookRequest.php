<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\ReadBookRequest;

use App\Application\Query\QueryInterface;
use App\Application\Query\RetrieveBook;
use App\Infrastructure\Http\Request\Book\BookRequest;
use Override;

final class ReadBookRequest extends BookRequest
{
    protected string $resourceId;

    /** @var string[]  */
    protected array $canBeIncluded = ['authors', 'genres'];

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return RetrieveBook::fromString($this->resourceId);
    }

    protected function validate(): void
    {
        $this->requestValidator->validateBookId($this->resourceId);
    }
}
