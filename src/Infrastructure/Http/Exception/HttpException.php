<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpException as SlimHttpException;
use Throwable;

class HttpException extends SlimHttpException
{
}
