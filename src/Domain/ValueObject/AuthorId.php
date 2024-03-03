<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Override;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class AuthorId extends AbstractValueObject
{
    protected function __construct(protected UuidInterface $uuid)
    {
        parent::__construct($this->uuid);
    }

    public static function fromUuid(?UuidInterface $uuid = null): self
    {
        return new self($uuid ?? Uuid::uuid4());
    }

    public static function fromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    public function toUuid(): UuidInterface
    {
        return $this->uuid;
    }

    #[Override] public function get(): string
    {
        return $this->uuid->toString();
    }

    #[Override] public function isEqualTo(self|ValueObjectInterface $valueObject): bool
    {
        return ($valueObject::class === self::class) && ($this->uuid->equals($valueObject->uuid));
    }

    public function __toString()
    {
        return $this->uuid->toString();
    }
}
