<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\UpdateAuthorRequest;

use App\Application\Command\CommandInterface;
use App\Application\Command\ModifyAuthor;
use App\Domain\ValueObject\AuthorId;
use App\Infrastructure\Http\Request\Author\UpdateAuthorRequest\Component\Resource;
use App\Infrastructure\Http\Request\Mapper;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use App\Infrastructure\Http\Validator\Type;
use Psr\Http\Message\ServerRequestInterface;
use Webmozart\Assert\Assert;

final class UpdateAuthorRequest implements RequestInterface
{
    protected Resource $resource;

    protected string $type = Type::AUTHORS->value;

    protected string $resourceId;

    public function __construct(
        ServerRequestInterface $serverRequest,
        protected Mapper $mapper,
        protected RequestValidator $requestValidator,
    ) {
        $this->resource = $this->mapper->map(Resource::class, $serverRequest);
        $this->resourceId = $serverRequest->getAttribute('resource_id');
        $this->validate();
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

        $this->requestValidator->validaAuthorId($this->resource->id);
    }
}
