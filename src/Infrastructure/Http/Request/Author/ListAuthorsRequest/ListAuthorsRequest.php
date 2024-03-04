<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\ListAuthorsRequest;

use App\Application\Query\ListAuthors;
use App\Application\Query\QueryInterface;
use App\Infrastructure\Http\Request\AbstractRequest;
use App\Infrastructure\Http\Request\RequestInterface;
use Override;

final class ListAuthorsRequest extends AbstractRequest
{
    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return ListAuthors::all();
    }
}
