<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Domain\Dto\BookDto;
use App\Domain\Dto\DtoInterface;
use App\Infrastructure\Http\Response\Component\Relationship;

class BookSuccessResponse extends AbstractSuccessResponse
{
    /** @var BookDto */
    protected DtoInterface|BookDto $dto;

    #[\Override] protected function id(): string
    {
        return $this->dto->id;
    }

    #[\Override] protected function type(): string
    {
        return 'books';
    }

    #[\Override] protected function getAttributes(): array
    {
        return [
            'title' => $this->dto->title,
            'description' => $this->dto->description,
            'cover' => $this->dto->cover,
            'tags' => $this->dto->tags,
        ];
    }

    #[\Override] protected function getRelationships(): array
    {
        return [
            'authors' => (new Relationship(
                'authors',
                $this->dto->authors,
                $this->linkToSelf(),
            ))->toArray(),

            'genres' => (new Relationship(
                'genres',
                $this->dto->genres,
                $this->linkToSelf(),
            ))->toArray(),
        ];
    }
}
