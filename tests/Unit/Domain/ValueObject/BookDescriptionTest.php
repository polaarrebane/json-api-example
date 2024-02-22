<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\BookDescription;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class BookDescriptionTest extends Unit
{
    protected UnitTester $tester;

    public function testGet(): void
    {
        /** @var string $description */
        $description = $this->tester->faker()->paragraphs(3, true);
        $bookDescription = BookDescription::fromString($description);
        $this->assertEquals($description, $bookDescription->get());
    }
}
