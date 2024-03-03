<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Infrastructure\Http\Validator\RequestValidator;
use DI\Attribute\Inject;

abstract class AbstractRequest implements RequestInterface
{
    #[Inject]
    protected RequestValidator $requestValidator;
}
