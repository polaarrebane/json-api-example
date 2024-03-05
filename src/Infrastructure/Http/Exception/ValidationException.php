<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class ValidationException extends AbstractHttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '400 BAD REQUEST',
        int $code = RFC7231::BAD_REQUEST,
        string $detail = "",
        ?Throwable $previous = null
    ) {
        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', "Validation error")
            ->withAttribute('exception_detail', $detail)
            ->withAttribute('exception_code', ErrorCodesEnum::VALIDATION_EXCEPTION->value);

        parent::__construct($request, $message, $code, $previous);
    }
}
