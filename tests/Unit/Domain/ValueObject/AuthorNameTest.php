<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\AuthorName;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class AuthorNameTest extends Unit
{
    protected UnitTester $tester;

    public function testGet(): void
    {
        $name = $this->tester->faker()->name();
        $authorName = AuthorName::fromString($name);
        $this->assertEquals($name, $authorName->get());
    }
}
