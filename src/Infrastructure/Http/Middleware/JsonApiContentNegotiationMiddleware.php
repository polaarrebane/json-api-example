<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Middleware;

use App\Infrastructure\Http\Exception\ContentNegotiation\NotAcceptable;
use App\Infrastructure\Http\Exception\ContentNegotiation\UnsupportedMediaType;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JsonApiContentNegotiationMiddleware
{
    protected const string HEADER_ACCEPT = 'Accept';
    protected const string HEADER_CONTENT_TYPE = 'Content-Type';
    protected const string HEADER_VALUE = 'application/vnd.api+json';

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (
            !$request->hasHeader(self::HEADER_ACCEPT) ||
            $request->getHeaderLine(self::HEADER_ACCEPT) !== self::HEADER_VALUE
        ) {
            throw new NotAcceptable($request);
        }

        if (
            !$request->hasHeader(self::HEADER_CONTENT_TYPE) ||
            $request->getHeaderLine(self::HEADER_CONTENT_TYPE) !== self::HEADER_VALUE
        ) {
            throw new UnsupportedMediaType($request);
        }

        return $handler->handle($request)->withHeader(self::HEADER_CONTENT_TYPE, self::HEADER_VALUE);
    }
}
