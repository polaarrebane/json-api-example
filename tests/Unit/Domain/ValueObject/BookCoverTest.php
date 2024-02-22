<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\BookCover;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class BookCoverTest extends Unit
{
    protected UnitTester $tester;

    public function testGet(): void
    {
        $cover = $this->tester->faker()->imageUrl();
        $bookCover = BookCover::fromString($cover);
        $this->assertEquals($cover, $bookCover->get());
    }
}
