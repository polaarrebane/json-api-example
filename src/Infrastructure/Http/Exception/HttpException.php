<?php

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpException as SlimHttpException;
use Throwable;

class HttpException extends SlimHttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($request, $message, $code, $previous);
    }
}
