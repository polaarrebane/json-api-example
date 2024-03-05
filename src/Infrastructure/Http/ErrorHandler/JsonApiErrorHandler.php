<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\ErrorHandler;

use App\Infrastructure\Http\Exception\AbstractHttpException;
use App\Infrastructure\Http\Exception\HttpException;
use App\Infrastructure\Http\Exception\InternalServerError;
use App\Infrastructure\Http\Exception\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Slim\Handlers\ErrorHandler;
use Webmozart\Assert\InvalidArgumentException;

class JsonApiErrorHandler extends ErrorHandler
{
    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;

        if ($exception instanceof InvalidArgumentException) {
            $this->exception = new ValidationException(
                request: $this->request,
                detail: $exception->getMessage(),
                previous: $exception
            );
        } elseif (!($exception instanceof AbstractHttpException)) {
            if ($exception instanceof \Slim\Exception\HttpException) {
                $this->exception = new HttpException(
                    $exception
                );
            } else {
                $detail = ($this->displayErrorDetails)
                    ? $exception->getMessage()
                    : 'Internal error';

                $this->exception = new InternalServerError(
                    request: $this->request,
                    detail: $detail,
                    previous: $exception
                );
            }
        }

        $response = $this->responseFactory->createResponse($this->statusCode);

        if ($this->contentType !== null && array_key_exists($this->contentType, $this->errorRenderers)) {
            $response = $response->withHeader('Content-type', $this->contentType);
        } else {
            $response = $response->withHeader('Content-Type', $this->defaultErrorRendererContentType);
        }

        $renderer = $this->determineRenderer();
        $body = $renderer($this->exception, $this->displayErrorDetails);

        if ($body !== false) {
            /** @var string $body */
            $response->getBody()->write($body);
        }

        return $response;
    }
}
