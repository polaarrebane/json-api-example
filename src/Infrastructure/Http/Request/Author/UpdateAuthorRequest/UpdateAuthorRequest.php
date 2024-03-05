<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\UpdateAuthorRequest;

use App\Application\Command\CommandInterface;
use App\Application\Command\ModifyAuthor;
use App\Domain\ValueObject\AuthorId;
use App\Infrastructure\Http\Exception\ResourceNotFoundException;
use App\Infrastructure\Http\Request\AbstractRequest;
use App\Infrastructure\Http\Request\Author\UpdateAuthorRequest\Component\Resource;
use App\Infrastructure\Http\Validator\Type;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

final class UpdateAuthorRequest extends AbstractRequest
{
    protected Resource $resource;

    protected string $type = Type::AUTHORS->value;

    protected string $resourceId;

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function toBusRequest(): CommandInterface
    {
        return new ModifyAuthor(
            authorId: AuthorId::fromString($this->resource->id),
            name: $this->resource->attributes->name,
        );
    }

    protected function validate(): void
    {
        Assert::eq($this->resource->type, $this->type, 'Type should be "' . $this->type . '"');

        Assert::eq(
            $this->resource->id,
            $this->resourceId,
            'The identifier from the path and the identifier from the document body must be identical.'
        );

        try {
            $this->requestValidator->validaAuthorId($this->resource->id);
        } catch (InvalidArgumentException $exception) {
            throw new ResourceNotFoundException(
                request: $this->serverRequest,
                detail: $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
