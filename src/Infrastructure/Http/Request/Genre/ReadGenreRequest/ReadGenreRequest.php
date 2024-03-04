<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Genre\ReadGenreRequest;

use App\Application\Query\QueryInterface;
use App\Application\Query\RetrieveGenre;
use App\Infrastructure\Http\Request\Book\BookRequest;
use Override;

final class ReadGenreRequest extends BookRequest
{
    protected string $resourceId;

    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return RetrieveGenre::fromString($this->resourceId);
    }

    protected function validate(): void
    {
        $this->requestValidator->validaGenreAbbreviation($this->resourceId);
    }
}
