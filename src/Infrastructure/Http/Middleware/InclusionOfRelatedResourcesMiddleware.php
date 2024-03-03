<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Middleware;

use App\Infrastructure\Http\Exception\EndpointDoesNotSupportTheIncludeParameter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class InclusionOfRelatedResourcesMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $queryParams = $request->getQueryParams();

        if (isset($queryParams['include'])) {
            throw new EndpointDoesNotSupportTheIncludeParameter($request);
        }

        return $handler->handle($request);
    }
}
