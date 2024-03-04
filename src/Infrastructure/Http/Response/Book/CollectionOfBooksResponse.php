<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Book;

use App\Domain\Dto\BookDto;
use App\Domain\Dto\DtoInterface;
use App\Infrastructure\Http\Response\CollectionResponse;
use App\Infrastructure\Http\Response\Component\Relationship;
use Override;

class CollectionOfBooksResponse extends CollectionResponse
{
    use IncludeResourcesOfBook;

    /**
     * @return string[]
     */
    public function resourceIds(): array
    {
        return array_map(
            static fn(DtoInterface|BookDto $dto) => $dto->id,
            $this->collection
        );
    }

    #[Override] protected function type(): string
    {
        return 'books';
    }

    /**
     * @param BookDto $dto
     * @return array<string,mixed>
     */
    protected function getAttributes(BookDto $dto): array
    {
        return [
            'title' => $dto->title,
            'description' => $dto->description,
            'cover' => $dto->cover,
            'tags' => $dto->tags,
        ];
    }

    /**
     * @param BookDto $dto
     * @return array<string,mixed>
     */
    protected function getRelationships(BookDto $dto): array
    {
        return [
            'authors' => (new Relationship(
                'authors',
                $dto->authors,
                $this->linkToSelf() . '/' . $dto->id,
            ))->toArray(),

            'genres' => (new Relationship(
                'genres',
                $dto->genres,
                $this->linkToSelf() . '/' . $dto->id,
            ))->toArray(),
        ];
    }

    /**
     * @param BookDto $dto
     * @return array<string,mixed>
     */
    #[Override] protected function dtoToArray(DtoInterface|BookDto $dto): array
    {
        return [
            'type' => $this->type(),
            'id' => $dto->id,
            'attributes' => $this->getAttributes($dto),
            'relationships' => $this->getRelationships($dto),
        ];
    }
}
