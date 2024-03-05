<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\ReadAuthorRequest;

use App\Application\Query\QueryInterface;
use App\Application\Query\RetrieveAuthor;
use App\Infrastructure\Http\Exception\ResourceNotFoundException;
use App\Infrastructure\Http\Request\AbstractRequest;
use Override;
use Webmozart\Assert\InvalidArgumentException;

final class ReadAuthorRequest extends AbstractRequest
{
    protected string $resourceId;

    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return RetrieveAuthor::fromString($this->resourceId);
    }

    protected function validate(): void
    {
        try {
            $this->requestValidator->validaAuthorId($this->resourceId);
        } catch (InvalidArgumentException $exception) {
            throw new ResourceNotFoundException(
                request: $this->serverRequest,
                detail: $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
