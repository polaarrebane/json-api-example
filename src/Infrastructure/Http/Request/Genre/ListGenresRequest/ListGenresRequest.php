<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Genre\ListGenresRequest;

use App\Application\Query\ListGenres;
use App\Application\Query\QueryInterface;
use App\Infrastructure\Http\Request\AbstractRequest;
use Override;

final class ListGenresRequest extends AbstractRequest
{
    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return ListGenres::all();
    }
}
