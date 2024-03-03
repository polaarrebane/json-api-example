<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Genre\ListGenresRequest;

use App\Application\Query\ListGenres;
use App\Application\Query\QueryInterface;
use App\Infrastructure\Http\Request\RequestInterface;
use Override;

final class ListGenresRequest implements RequestInterface
{
    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return ListGenres::all();
    }
}
