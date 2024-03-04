<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Author;

use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\RFC\RFC7231;

class CreateAuthorResponse extends SingleAuthorResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return parent::toPsrResponse()->withHeader('Location', $this->linkToSelf())->withStatus(RFC7231::CREATED);
    }
}
