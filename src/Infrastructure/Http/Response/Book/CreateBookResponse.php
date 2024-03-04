<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Book;

use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\RFC\RFC7231;

class CreateBookResponse extends SingleBookResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return parent::toPsrResponse()->withHeader('Location', $this->linkToSelf())->withStatus(RFC7231::CREATED);
    }
}
