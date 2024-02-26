<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Application\Command\AddNewBook;
use App\Application\Command\CommandInterface;
use App\Infrastructure\Http\Request\Component\BookAttributes;
use App\Infrastructure\Http\Request\Component\BookRelationships;
use App\Infrastructure\Http\Request\Component\RelationshipItem;

final readonly class CreateBookRequest implements RequestInterface
{
    public function __construct(
        public string $type,
        public BookAttributes $attributes,
        public BookRelationships $relationships,
    ) {
    }

    public function toCommand(): CommandInterface
    {
        $authors = array_map(
            static fn(RelationshipItem $item) => $item->id,
            $this->relationships->authors->data,
        );

        $genres = array_map(
            static fn(RelationshipItem $item) => $item->id,
            $this->relationships->genres->data,
        );

        return new AddNewBook(
            title: $this->attributes->title,
            description: $this->attributes->description,
            cover: $this->attributes->cover,
            authors: $authors,
            genres: $genres,
            tags: $this->attributes->tags,
        );
    }
}
