<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\UpdateBookRequest;

use App\Application\Command\CommandInterface;
use App\Application\Command\ModifyBook;
use App\Domain\ValueObject\BookId;
use App\Infrastructure\Http\Request\Book\UpdateBookRequest\Component\Resource;
use App\Infrastructure\Http\Request\Mapper;
use App\Infrastructure\Http\Request\RelationshipItem;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use App\Infrastructure\Http\Validator\Type;
use Psr\Http\Message\ServerRequestInterface;
use Webmozart\Assert\Assert;

final class UpdateBookRequest implements RequestInterface
{
    protected Resource $resource;

    protected string $type = Type::BOOKS->value;

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
        $authors = $this->resource->relationships?->authors
            ? array_map(
                static fn(RelationshipItem $item) => $item->id,
                $this->resource->relationships->authors->data,
            )
            : null;

        $genres = $this->resource->relationships?->genres
            ? array_map(
                static fn(RelationshipItem $item) => $item->id,
                $this->resource->relationships->genres->data,
            )
            : null;

        return new ModifyBook(
            bookId: BookId::fromString($this->resource->id),
            title: $this->resource->attributes?->title,
            description: $this->resource->attributes?->description,
            cover: $this->resource->attributes?->cover,
            authors: $authors,
            genres: $genres,
            tags: $this->resource->attributes?->tags,
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

        $this->requestValidator->validateBookId($this->resource->id);

        if ($this->resource->attributes?->cover) {
            $this->requestValidator->validateCover($this->resource->attributes->cover);
        }

        if ($this->resource->attributes?->tags) {
            $this->requestValidator->validateTags($this->resource->attributes->tags);
        }

        if ($this->resource->relationships?->authors) {
            $this->requestValidator->validateAuthors($this->resource->relationships->authors->data);
        }

        if ($this->resource->relationships?->genres) {
            $this->requestValidator->validateGenres($this->resource->relationships->genres->data);
        }
    }
}
