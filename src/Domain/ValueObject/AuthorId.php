<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class AuthorId extends AbstractValueObject
{
    protected function __construct(protected UuidInterface $uuid)
    {
        parent::__construct($this->uuid);
    }

    public static function fromUuid(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    public function __toString()
    {
        return $this->uuid->toString();
    }

    public function get(): string
    {
        return $this->uuid->toString();
    }

    public function isEqualTo(self|ValueObjectInterface $valueObject): bool
    {
        return ($valueObject::class === self::class) && ($this->uuid->equals($valueObject->uuid));
    }
}
