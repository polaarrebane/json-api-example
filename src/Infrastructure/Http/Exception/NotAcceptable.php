<?php

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class NotAcceptable extends HttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '406 NOT ACCEPTABLE',
        int $code = RFC7231::NOT_ACCEPTABLE,
        ?Throwable $previous = null
    ) {
        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', "Request’s Accept header contains unsupported media type")
            ->withAttribute('exception_detail', "See https://jsonapi.org/format/#content-negotiation for details")
            ->withAttribute('exception_code', ErrorCodesEnum::CONTENT_NEGOTIATION_NOT_ACCEPTABLE->value);

        parent::__construct($request, $message, $code, $previous);
    }
}
