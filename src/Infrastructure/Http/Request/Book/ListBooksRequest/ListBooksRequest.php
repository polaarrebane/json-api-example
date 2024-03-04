<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\ListBooksRequest;

use App\Application\Query\ListBooks;
use App\Application\Query\QueryInterface;
use App\Infrastructure\Http\Request\Book\BookRequest;
use Override;

final class ListBooksRequest extends BookRequest
{
    /** @var string[]  */
    protected array $canBeIncluded = ['authors', 'genres'];

    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return ListBooks::all();
    }
}
