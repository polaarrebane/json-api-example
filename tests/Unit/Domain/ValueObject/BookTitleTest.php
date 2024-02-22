<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\BookTitle;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class BookTitleTest extends Unit
{
    protected UnitTester $tester;

    public function testGet(): void
    {
        $title = $this->tester->faker()->word();
        $bookTitle = BookTitle::fromString($title);
        $this->assertEquals($title, $bookTitle->get());
    }
}
