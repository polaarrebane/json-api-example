<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Domain\Dto\DtoInterface;
use League\Config\Configuration;
use RuntimeException;
use Slim\Psr7\Response;
use Spatie\Url\Url;

abstract class SingleResourceResponse extends AbstractApiResponse
{
    protected DtoInterface $dto;

    /** @var array<string, mixed> */
    protected array $included;

    /**
     * @return string[]
     */
    public function resourceIds(): array
    {
        return [$this->id()];
    }

    public function setResource(DtoInterface $dto): self
    {
        $this->dto = $dto;

        return $this;
    }

    protected function linkToSelf(): string
    {
        return (string)Url::create()
            ->withScheme($this->config->get('app.scheme'))
            ->withHost($this->config->get('app.host'))
            ->withPath(implode('/', [$this->config->get('app.api_base_path'), $this->type(), $this->id()]));
    }

    abstract protected function id(): string;

    /**
     * @return array<string, mixed>
     */
    abstract protected function getAttributes(): array;

    /**
     * @return array<string, mixed>
     */
    abstract protected function getRelationships(): array;

    /**
     * @return array<string, mixed>
     */
    protected function toArray(bool $wrap = true): array
    {
        if (!isset($this->dto)) {
            throw new RuntimeException('The resource is missed');
        }

        $result = [
            'type' => $this->type(),
            'id' => $this->id(),
            'attributes' => $this->getAttributes(),
            'relationships' => $this->getRelationships(),
        ];

        if ($wrap) {
            $result = ['data' => $result];
        }

        $result['links'] = $this->getLinks();

        if (isset($this->included)) {
            $result['included'] = $this->included;
        }

        return $result;
    }
}
