<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class ResourceNotFoundException extends AbstractHttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '404 NOT FOUND',
        int $code = RFC7231::NOT_FOUND,
        string $detail = "",
        ?Throwable $previous = null
    ) {
        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', "Resource not found")
            ->withAttribute('exception_detail', $detail)
            ->withAttribute('exception_code', ErrorCodesEnum::RESOURCE_NOT_FOUND->value);

        parent::__construct($request, $message, $code, $previous);
    }
}
