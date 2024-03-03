<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Author;

use App\Domain\Dto\AuthorDto;
use App\Domain\Dto\DtoInterface;
use App\Infrastructure\Http\Response\CollectionResourceResponse;
use Override;

class AuthorCollectionResponse extends CollectionResourceResponse
{
    #[Override] protected function type(): string
    {
        return 'authors';
    }

    /**
     * @param AuthorDto $dto
     * @return array<string,mixed>
     */
    protected function getAttributes(AuthorDto $dto): array
    {
        return [
            'name' => $dto->name,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getRelationships(AuthorDto $dto): array
    {
        return [];
    }

    /**
     * @param AuthorDto $dto
     * @return array<string, mixed>
     */
    #[Override] protected function dtoToArray(DtoInterface|AuthorDto $dto): array
    {
        return [
            'type' => $this->type(),
            'id' => $dto->id,
            'attributes' => $this->getAttributes($dto),
            'relationships' => $this->getRelationships($dto),
        ];
    }
}
