<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\BookId;
use Codeception\Test\Unit;
use Ramsey\Uuid\Uuid;
use Tests\Support\UnitTester;

class BookIdTest extends Unit
{
    protected UnitTester $tester;

    public function testFromUuid(): void
    {
        $bookId = BookId::fromUuid();

        $this->assertTrue(Uuid::isValid($bookId->get()));
    }

    public function testIsEqualTo(): void
    {
        $bookId = BookId::fromUuid();
        $bookIdClone = clone $bookId;
        $anotherBookId = BookId::fromUuid();

        $this->assertTrue($bookId->isEqualTo($bookId));
        $this->assertTrue($bookId->isEqualTo($bookIdClone));
        $this->assertFalse($bookId->isEqualTo($anotherBookId));
    }

    public function testGet(): void
    {
        $bookId = BookId::fromUuid();

        $this->assertTrue(Uuid::isValid($bookId->get()));
    }
}
