<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class InclusionOfRelatedResourcesMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $queryParams = $request->getQueryParams();

        if (isset($queryParams['include'])) {
            $request = $request->withAttribute('include', explode(',', $queryParams['include']));
        }

        if (isset($queryParams['fields'])) {
            $sparseFieldsets = [];

            foreach ($queryParams['fields'] as $resource => $fields) {
                if (!$fields) {
                    $sparseFieldsets[$resource] = [];
                } else {
                    $sparseFieldsets[$resource] = explode(',', $fields);
                }
            }

            $request = $request->withAttribute('sparse_fieldsets', $sparseFieldsets);
        }

        return $handler->handle($request);
    }
}
