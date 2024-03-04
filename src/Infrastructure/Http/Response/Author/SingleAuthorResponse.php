<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Author;

use App\Domain\Dto\AuthorDto;
use App\Domain\Dto\DtoInterface;
use App\Infrastructure\Http\Response\SingleResourceResponse;
use Override;

class SingleAuthorResponse extends SingleResourceResponse
{
    /** @var AuthorDto */
    protected DtoInterface|AuthorDto $dto;

    #[Override] protected function id(): string
    {
        return $this->dto->id;
    }

    #[Override] protected function type(): string
    {
        return 'authors';
    }

    #[Override] protected function getAttributes(): array
    {
        return [
            'name' => $this->dto->name,
        ];
    }

    #[Override] protected function getRelationships(): array
    {
        return [];
    }
}
