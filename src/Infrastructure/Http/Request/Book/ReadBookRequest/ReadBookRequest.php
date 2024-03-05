<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\ReadBookRequest;

use App\Application\Query\QueryInterface;
use App\Application\Query\RetrieveBook;
use App\Infrastructure\Http\Exception\ResourceNotFoundException;
use App\Infrastructure\Http\Request\Book\BookRequest;
use Override;
use Webmozart\Assert\InvalidArgumentException;

final class ReadBookRequest extends BookRequest
{
    protected string $resourceId;

    /** @var string[] */
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
        try {
            $this->requestValidator->validateBookId($this->resourceId);
        } catch (InvalidArgumentException $exception) {
            throw new ResourceNotFoundException(
                request: $this->serverRequest,
                detail: $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
