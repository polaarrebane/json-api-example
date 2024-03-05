<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception\ContentNegotiation;

use App\Infrastructure\Http\Exception\ErrorCodesEnum;
use App\Infrastructure\Http\Exception\AbstractHttpException;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class UnsupportedMediaType extends AbstractHttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '415 UNSUPPORTED MEDIA TYPE',
        int $code = RFC7231::UNSUPPORTED_MEDIA_TYPE,
        ?Throwable $previous = null
    ) {
        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', "Request’s Content-Type header contains unsupported media type")
            ->withAttribute('exception_detail', "See https://jsonapi.org/format/#content-negotiation for details")
            ->withAttribute('exception_code', ErrorCodesEnum::CONTENT_NEGOTIATION_UNSUPPORTED_MEDIA_TYPE->value);

        parent::__construct($request, $message, $code, $previous);
    }
}
