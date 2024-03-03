<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Application\Command\CommandInterface;
use App\Application\Query\QueryInterface;

interface RequestInterface
{
    public function toBusRequest(): CommandInterface|QueryInterface;
}
