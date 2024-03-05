<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Slim\Exception\HttpException as SlimHttpException;
use Teapot\StatusCode\RFC\RFC7231;
use Throwable;

class HttpException extends AbstractHttpException
{
    public function __construct(
        SlimHttpException $slimHttpException,
    ) {
        $request = $slimHttpException->getRequest();
        $title = $slimHttpException->getTitle();
        $code = $slimHttpException->getCode();
        $message = $slimHttpException->getMessage();
        $description = $slimHttpException->getDescription();

        $request = $request
            ->withAttribute('exception_uuid', Uuid::uuid4()->toString())
            ->withAttribute('exception_title', $title)
            ->withAttribute('exception_detail', $description)
            ->withAttribute('exception_code', ErrorCodesEnum::SLIM_HTTP_EXCEPTION);

        parent::__construct(
            $request,
            str_replace('.', '', strtoupper($code . ' ' . $message)),
            $code,
            $slimHttpException
        );
    }
}
