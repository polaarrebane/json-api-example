<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\ErrorHandler;

use App\Infrastructure\Http\Exception\HttpException;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class JsonApiErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $document = [
            'status' => $exception->getMessage()
        ];

        if ($exception instanceof HttpException) {
            $document['id'] = $exception->getRequest()->getAttribute('exception_uuid', '');
            $document['code'] = $exception->getRequest()->getAttribute('exception_code', '');
            $document['title'] = $exception->getRequest()->getAttribute('exception_title', '');
            $document['detail'] = $exception->getRequest()->getAttribute('exception_detail', '');
        }

        return (string)json_encode([
            'errors' => $document
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }
}
