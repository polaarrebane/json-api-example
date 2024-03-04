<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Domain\Dto\DtoInterface;
use Spatie\Url\Url;

abstract class CollectionResponse extends AbstractApiResponse
{
    /** @var DtoInterface[] */
    protected array $collection = [];

    /**
     * @param DtoInterface[] $collection
     * @return $this
     */
    public function setCollection(array $collection): self
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
        $result = [
            'links' => $this->getLinks(),
            'data' => array_map(
                fn(DtoInterface $dto) => $this->dtoToArray($dto),
                $this->collection
            ),
        ];

        if (isset($this->included)) {
            $result['included'] = $this->included;
        }

        return $result;
    }

    protected function linkToSelf(): string
    {
        return (string)Url::create()
            ->withScheme($this->config->get('app.scheme'))
            ->withHost($this->config->get('app.host'))
            ->withPath(implode('/', [$this->config->get('app.api_base_path'), $this->type()]));
    }
}
