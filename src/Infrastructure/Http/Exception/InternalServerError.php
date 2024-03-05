<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class InternalServerError extends AbstractHttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '500 INTERNAL_SERVER_ERROR',
        int $code = RFC7231::INTERNAL_SERVER_ERROR,
        string $detail = "",
        ?Throwable $previous = null
    ) {
        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', "Internal server error")
            ->withAttribute('exception_detail', $detail)
            ->withAttribute('exception_code', ErrorCodesEnum::INTERNAL_SERVER_ERROR->value);

        parent::__construct($request, $message, $code, $previous);
    }
}
