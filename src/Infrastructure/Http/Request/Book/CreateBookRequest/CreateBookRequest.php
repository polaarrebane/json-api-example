<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\CreateBookRequest;

use App\Application\Command\AddNewBook;
use App\Application\Command\CommandInterface;
use App\Infrastructure\Http\Request\Book\CreateBookRequest\Component\Resource;
use App\Infrastructure\Http\Request\Mapper;
use App\Infrastructure\Http\Request\RelationshipItem;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use App\Infrastructure\Http\Validator\Type;
use Psr\Http\Message\ServerRequestInterface;
use Webmozart\Assert\Assert;

final class CreateBookRequest implements RequestInterface
{
    protected Resource $resource;

    protected string $type = Type::BOOKS->value;

    public function __construct(
        ServerRequestInterface $serverRequest,
        protected Mapper $mapper,
        protected RequestValidator $requestValidator,
    ) {
        $this->resource = $this->mapper->map(Resource::class, $serverRequest);
        $this->validate();
    }

    public function toBusRequest(): CommandInterface
    {
        $authors = array_map(
            static fn(RelationshipItem $item) => $item->id,
            $this->resource->relationships->authors->data,
        );

        $genres = array_map(
            static fn(RelationshipItem $item) => $item->id,
            $this->resource->relationships->genres->data,
        );

        return new AddNewBook(
            title: $this->resource->attributes->title,
            description: $this->resource->attributes->description,
            cover: $this->resource->attributes->cover,
            authors: $authors,
            genres: $genres,
            tags: $this->resource->attributes->tags,
        );
    }

    protected function validate(): void
    {
        Assert::eq($this->resource->type, Type::BOOKS->value, 'Type should be "' . Type::BOOKS->value . '"');

        $this->requestValidator->validateCover($this->resource->attributes->cover);
        $this->requestValidator->validateTags($this->resource->attributes->tags);
        $this->requestValidator->validateAuthors($this->resource->relationships->authors->data);
        $this->requestValidator->validateGenres($this->resource->relationships->genres->data);
    }
}
