<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Genre;

use App\Domain\Dto\DtoInterface;
use App\Domain\Dto\GenreDto;
use App\Infrastructure\Http\Response\CollectionResponse;
use Override;

class GenreCollectionResponse extends CollectionResponse
{
    #[Override] protected function type(): string
    {
        return 'genres';
    }

    #[Override] public function resourceIds(): array
    {
        return array_map(
            static fn(DtoInterface|GenreDto $dto) => $dto->abbreviation,
            $this->collection
        );
    }

    /**
     * @param GenreDto $dto
     * @return array<string,mixed>
     */
    protected function getAttributes(GenreDto $dto): array
    {
        return [
            'description' => $dto->description,
        ];
    }

    /**
     * @param GenreDto $dto
     * @return array<string,mixed>
     */
    protected function getRelationships(GenreDto $dto): array
    {
        return [];
    }

    /**
     * @param GenreDto $dto
     * @return array<string,mixed>
     */
    #[Override] protected function dtoToArray(DtoInterface|GenreDto $dto): array
    {
        return [
            'type' => $this->type(),
            'id' => $dto->abbreviation,
            'attributes' => $this->getAttributes($dto),
            'relationships' => $this->getRelationships($dto),
        ];
    }
}
