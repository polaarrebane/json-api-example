<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Author;

use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\RFC\RFC7231;

class DeleteAuthorResponse extends SingleAuthorResponse
{
    public function toPsrResponse(): ResponseInterface
    {
        return $this->response->withStatus(RFC7231::NO_CONTENT);
    }
}
