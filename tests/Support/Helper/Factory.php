<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Factory extends \Codeception\Module
{
    protected readonly \Faker\Generator $faker;

    public function _initialize(): void
    {
        if (!isset($this->faker)) {
            $this->faker = \Faker\Factory::create();
        }
    }
}
