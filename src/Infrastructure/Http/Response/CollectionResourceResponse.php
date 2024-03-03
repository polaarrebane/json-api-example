<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Domain\Dto\DtoInterface;
use League\Config\Configuration;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Spatie\Url\Url;

abstract class CollectionResourceResponse extends AbstractResponse
{
    /** @var DtoInterface[] */
    protected array $collection = [];

    /**
     * @param DtoInterface[] $collection
     * @return $this
     */
    public function withCollection(array $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @param DtoInterface $dto
     * @return array<string, mixed>
     */
    abstract protected function dtoToArray(DtoInterface $dto): array;

    /**
     * @return array<string, mixed>
     */
    protected function toArray(): array
    {
        return [
            'links' => $this->getLinks(),
            'data' => array_map(
                fn(DtoInterface $dto) => $this->dtoToArray($dto),
                $this->collection
            ),
        ];
    }

    protected function linkToSelf(): string
    {
        return (string)Url::create()
            ->withScheme($this->config->get('app.scheme'))
            ->withHost($this->config->get('app.host'))
            ->withPath(implode('/', [$this->config->get('app.api_base_path'), $this->type()]));
    }
}
