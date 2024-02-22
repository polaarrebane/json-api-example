<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Faker\Factory;

class Faker extends \Codeception\Module
{
    protected readonly \Faker\Generator $faker;

    public function _initialize(): void
    {
        if (!isset($this->faker)) {
            $this->faker = Factory::create();
        }
    }

    public function faker(): \Faker\Generator
    {
        return $this->faker;
    }
}
