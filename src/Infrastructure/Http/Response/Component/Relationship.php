<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Component;

class Relationship
{
    public function __construct(
        protected string $type,
        /** @var string[] $ids */
        protected array $ids,
        protected string $linkToSelf,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'links' => [
                'self' => $this->linkToSelf . '/' . $this->type,
            ],
            'data' => array_map(
                fn(string $id) => [
                'type' => $this->type,
                'id' => $id,
                ],
                $this->ids,
            )
        ];
    }
}
