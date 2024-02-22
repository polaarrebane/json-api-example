<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\TagValue;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class TagValueTest extends Unit
{
    protected UnitTester $tester;

    public function testGet(): void
    {
        $tag = $this->tester->faker()->word();
        $tagValue = TagValue::fromString($tag);
        $this->assertEquals($tag, $tagValue->get());
    }
}
