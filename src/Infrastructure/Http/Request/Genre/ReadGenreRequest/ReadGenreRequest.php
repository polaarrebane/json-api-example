<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Genre\ReadGenreRequest;

use App\Application\Query\QueryInterface;
use App\Application\Query\RetrieveGenre;
use App\Infrastructure\Http\Exception\ResourceNotFoundException;
use App\Infrastructure\Http\Request\Book\BookRequest;
use Override;
use Webmozart\Assert\InvalidArgumentException;

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
        try {
            $this->requestValidator->validaGenreAbbreviation($this->resourceId);
        } catch (InvalidArgumentException $exception) {
            throw new ResourceNotFoundException(
                request: $this->serverRequest,
                detail: $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
