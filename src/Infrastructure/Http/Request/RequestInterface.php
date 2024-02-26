<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Application\Command\CommandInterface;

interface RequestInterface
{
    public function toCommand(): CommandInterface;
}
