<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class EndpointDoesNotSupportTheIncludeParameter extends HttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '400 BAD REQUEST',
        int $code = RFC7231::BAD_REQUEST,
        ?Throwable $previous = null
    ) {
        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', "An endpoint does not support the include parameter")
            ->withAttribute('exception_detail', "See https://jsonapi.org/format/#fetching-includes for details")
            ->withAttribute('exception_code', ErrorCodesEnum::AN_ENDPOINT_DOES_NOT_SUPPORT_THE_INCLUDE_PARAMETER->value);

        parent::__construct($request, $message, $code, $previous);
    }
}
