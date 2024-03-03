<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use Psr\Http\Message\ResponseInterface;

interface ApiResponseInterface
{
    public function toPsrResponse(): ResponseInterface;
}
