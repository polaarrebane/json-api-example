<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Book;

use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\RFC\RFC7231;

class DeleteBookResponse extends SingleBookResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return $this->response->withStatus(RFC7231::NO_CONTENT);
    }
}
