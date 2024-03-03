<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\ListBooksRequest;

use App\Application\Query\ListBooks;
use App\Application\Query\QueryInterface;
use App\Infrastructure\Http\Request\RequestInterface;
use Override;

final class ListBooksRequest implements RequestInterface
{
    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return ListBooks::all();
    }
}
