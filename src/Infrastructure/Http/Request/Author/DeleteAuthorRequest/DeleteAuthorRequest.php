<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\DeleteAuthorRequest;

use App\Application\Command\CommandInterface;
use App\Application\Command\DestroyAuthor;
use App\Infrastructure\Http\Exception\ResourceNotFoundException;
use App\Infrastructure\Http\Request\AbstractRequest;
use Override;
use Webmozart\Assert\InvalidArgumentException;

final class DeleteAuthorRequest extends AbstractRequest
{
    protected string $resourceId;

    #[Override]
    public function toBusRequest(): CommandInterface
    {
        return DestroyAuthor::fromString($this->resourceId);
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
