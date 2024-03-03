<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Book;

use Psr\Http\Message\ResponseInterface;

class BookCreatedResponse extends BookResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return parent::toPsrResponse()->withHeader('Location', $this->linkToSelf());
    }
}
