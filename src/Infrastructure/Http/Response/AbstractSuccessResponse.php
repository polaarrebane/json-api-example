<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Domain\Dto\DtoInterface;
use League\Config\Configuration;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractSuccessResponse implements ApiResponseInterface
{
    final protected function __construct(
        protected DtoInterface $dto,
        protected ResponseInterface $response,
        protected Configuration $config,
    ) {
    }

    public static function fromDto(DtoInterface $dto, ResponseInterface $response, Configuration $config): ApiResponseInterface
    {
        return new static($dto, $response, $config);
    }

    public function toResponse(): ResponseInterface
    {
        $this->response->getBody()->write(
            json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        return $this->response;
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function getAttributes(): array;

    /**
     * @return array<string, mixed>
     */
    abstract protected function getRelationships(): array;

    abstract protected function id(): string;

    abstract protected function type(): string;

    protected function linkToSelf(): string
    {
        return $this->config->get('app.url') . '/' . $this->type() . '/' . $this->id();
    }

    /**
     * @return array<string,string>
     */
    protected function getLinks(): array
    {
        return ['self' => $this->linkToSelf()];
    }

    /**
     * @return array<string, mixed>
     */
    protected function toArray(): array
    {
        return [
            'data' => [
                'type' => $this->type(),
                'id' => $this->id(),
                'attributes' => $this->getAttributes(),
                'relationships' => $this->getRelationships(),
            ],
            'links' => $this->getLinks(),
        ];
    }
}
