<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Author;

use Psr\Http\Message\ResponseInterface;

class AuthorCreatedResponse extends AuthorResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return parent::toPsrResponse()->withHeader('Location', $this->linkToSelf());
    }
}
