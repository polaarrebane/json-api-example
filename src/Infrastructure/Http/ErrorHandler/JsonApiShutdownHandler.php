<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\ErrorHandler;

use App\Infrastructure\Http\Exception\InternalServerError;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\ErrorHandler;
use Slim\ResponseEmitter;

class JsonApiShutdownHandler
{
    /**
     * @var ServerRequestInterface
     */
    private ServerRequestInterface $request;

    /**
     * @var ErrorHandler
     */
    private ErrorHandler $errorHandler;

    /**
     * @var bool
     */
    private bool $displayErrorDetails;

    /**
     * ShutdownHandler constructor.
     *
     * @param ServerRequestInterface $request
     * @param ErrorHandler $errorHandler
     * @param bool $displayErrorDetails
     */
    public function __construct(ServerRequestInterface $request, ErrorHandler $errorHandler, bool $displayErrorDetails)
    {
        $this->request = $request;
        $this->errorHandler = $errorHandler;
        $this->displayErrorDetails = $displayErrorDetails;
    }

    public function __invoke(): void
    {
        $error = error_get_last();
        if ($error) {
            $errorFile = $error['file'];
            $errorLine = $error['line'];
            $errorMessage = $error['message'];
            $message = 'An error while processing your request. Please try again later.';

            $errorType = match ($error['type']) {
                E_ERROR => "E_ERROR",
                E_WARNING => "E_WARNING",
                E_PARSE => "E_PARSE",
                E_NOTICE => "E_NOTICE",
                E_CORE_ERROR => "E_CORE_ERROR",
                E_CORE_WARNING => "E_CORE_WARNING",
                E_COMPILE_ERROR => "E_COMPILE_ERROR",
                E_COMPILE_WARNING => "E_COMPILE_WARNING",
                E_USER_ERROR => "E_USER_ERROR",
                E_USER_WARNING => "E_USER_WARNING",
                E_USER_NOTICE => "E_USER_NOTICE",
                E_STRICT => "E_STRICT",
                E_RECOVERABLE_ERROR => "E_RECOVERABLE_ERROR",
                E_DEPRECATED => "E_DEPRECATED",
                E_USER_DEPRECATED => "E_USER_DEPRECATED",

                default => "ERROR",
            };

            if ($this->displayErrorDetails) {
                $message = "$errorType: $errorMessage on line $errorLine in file $errorFile.";
            }

            $exception = new InternalServerError($this->request, detail: $message);
            $response = $this->errorHandler->__invoke($this->request, $exception, $this->displayErrorDetails, false, false);

            if (ob_get_length()) {
                ob_clean();
            }

            $responseEmitter = new ResponseEmitter();
            $responseEmitter->emit($response);
        }
    }
}
