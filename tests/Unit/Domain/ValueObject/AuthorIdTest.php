<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\AuthorId;
use Codeception\Test\Unit;
use Ramsey\Uuid\Uuid;
use Tests\Support\UnitTester;

class AuthorIdTest extends Unit
{
    protected UnitTester $tester;

    public function testFromUuid(): void
    {
        $authorId = AuthorId::fromUuid();

        $this->assertTrue(Uuid::isValid($authorId->get()));
    }

    public function testIsEqualTo(): void
    {
        $authorId = AuthorId::fromUuid();
        $authorIdClone = clone $authorId;
        $anotherAuthorId = AuthorId::fromUuid();

        $this->assertTrue($authorId->isEqualTo($authorId));
        $this->assertTrue($authorId->isEqualTo($authorIdClone));
        $this->assertFalse($authorId->isEqualTo($anotherAuthorId));
    }

    public function testGet(): void
    {
        $authorId = AuthorId::fromUuid();

        $this->assertTrue(Uuid::isValid($authorId->get()));
    }
}
