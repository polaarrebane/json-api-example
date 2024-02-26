<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

enum ErrorCodesEnum: int
{
    case CONTENT_NEGOTIATION_NOT_ACCEPTABLE = 1000;
    case CONTENT_NEGOTIATION_UNSUPPORTED_MEDIA_TYPE = 1001;
}
