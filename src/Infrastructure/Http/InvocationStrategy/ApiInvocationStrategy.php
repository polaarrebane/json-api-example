<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\InvocationStrategy;

use App\Infrastructure\Http\Exception\AbstractHttpException;
use App\Infrastructure\Http\Exception\InternalServerError;
use App\Infrastructure\Http\Exception\ValidationException;
use App\Infrastructure\Http\Response\AbstractApiResponse;
use DI\Attribute\Inject;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;
use ReflectionMethod;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Webmozart\Assert\InvalidArgumentException;

class ApiInvocationStrategy extends RequestResponseArgs
{
    #[Inject]
    protected Container $container;

    /**
     * @param callable $callable
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array<string, string> $routeArguments
     * @return ResponseInterface
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ): ResponseInterface {
        $request = $this->addAttributesToRequest($request, $routeArguments);
        $this->container->set(ServerRequestInterface::class, $request);

        $result = $callable(...$this->getArgsFromContainer($callable));

        if ($result instanceof AbstractApiResponse) {
            return $result->toPsrResponse();
        }

        return $result;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array<string, string> $routeArguments
     * @return ServerRequestInterface
     */
    protected function addAttributesToRequest(
        ServerRequestInterface $request,
        array $routeArguments,
    ): ServerRequestInterface {
        if (isset($routeArguments['resource_id'])) {
            $request = $request->withAttribute('resource_id', $routeArguments['resource_id']);
        }

        return $request;
    }

    /**
     * @param callable $callable
     * @return array<string,mixed>
     * @throws DependencyException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    protected function getArgsFromContainer(callable $callable): array
    {
        $reflection = new ReflectionMethod($callable[0], $callable[1]);

        $args = [];
        foreach ($reflection->getParameters() as $parameter) {
            $args[$parameter->name] = $this->container->get($parameter->getType()->getName());
        }

        return $args;
    }
}
