<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Author;

use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\RFC\RFC7231;

class UpdateAuthorResponse extends SingleAuthorResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return parent::toPsrResponse()->withStatus(RFC7231::ACCEPTED);
    }
}
