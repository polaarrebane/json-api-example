<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Book;

use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\RFC\RFC7231;

class UpdateBookResponse extends SingleBookResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return parent::toPsrResponse()->withStatus(RFC7231::ACCEPTED);
    }
}
