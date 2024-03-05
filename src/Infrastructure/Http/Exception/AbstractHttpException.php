<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Exception;

use Slim\Exception\HttpException as SlimHttpException;

abstract class AbstractHttpException extends SlimHttpException
{
}
