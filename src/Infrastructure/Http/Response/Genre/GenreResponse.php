<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Genre;

use App\Domain\Dto\DtoInterface;
use App\Domain\Dto\GenreDto;
use App\Infrastructure\Http\Response\SingleResourceResponse;
use Override;

class GenreResponse extends SingleResourceResponse
{
    /** @var GenreDto */
    protected DtoInterface|GenreDto $dto;

    #[Override] protected function id(): string
    {
        return $this->dto->abbreviation;
    }

    #[Override] protected function type(): string
    {
        return 'genres';
    }

    #[Override] protected function getAttributes(): array
    {
        return [
            'description' => $this->dto->description,
        ];
    }

    #[Override] protected function getRelationships(): array
    {
        return [];
    }
}
