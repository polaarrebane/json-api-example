<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception\Include;

use App\Infrastructure\Http\Exception\ErrorCodesEnum;
use App\Infrastructure\Http\Exception\AbstractHttpException;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class IncorrectInclusionField extends AbstractHttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = '400 BAD REQUEST',
        int $code = RFC7231::BAD_REQUEST,
        ?Throwable $previous = null
    ) {
        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', "The inclusion field is specified incorrectly.")
            ->withAttribute('exception_detail', "See https://jsonapi.org/format/#fetching-includes for details")
            ->withAttribute('exception_code', ErrorCodesEnum::INCORRECT_INCLUSION_FIELD->value);

        parent::__construct($request, $message, $code, $previous);
    }
}
