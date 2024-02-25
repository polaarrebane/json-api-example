<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Application\Command\CommandInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestInterface
{
    public static function fromServerRequest(ServerRequestInterface $request): self;

    public function toCommand(): CommandInterface;
}
