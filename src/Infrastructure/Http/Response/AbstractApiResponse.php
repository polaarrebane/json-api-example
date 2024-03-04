<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use DI\Container;
use League\Config\Configuration;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

abstract class AbstractApiResponse implements ApiResponseInterface
{
    final public function __construct(
        protected Response $response,
        protected Configuration $config,
        protected Container $container,
    ) {
    }

    /**
     * @return string[]
     */
    abstract public function resourceIds(): array;

    public function toPsrResponse(): ResponseInterface
    {
        $this->response->getBody()->write(
            json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        return $this->response;
    }

    /**
     * @return array<string,string>
     */
    protected function getLinks(): array
    {
        return ['self' => $this->linkToSelf()];
    }

    abstract protected function type(): string;

    /**
     * @return array<string, mixed>
     */
    abstract protected function toArray(): array;

    abstract protected function linkToSelf(): string;
}
