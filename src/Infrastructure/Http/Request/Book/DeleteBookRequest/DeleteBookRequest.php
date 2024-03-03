<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\DeleteBookRequest;

use App\Application\Command\CommandInterface;
use App\Application\Command\DestroyBook;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use Override;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteBookRequest implements RequestInterface
{
    protected string $resourceId;

    public function __construct(
        ServerRequestInterface $serverRequest,
        protected RequestValidator $requestValidator,
    ) {
        $this->resourceId = $serverRequest->getAttribute('resource_id');
        $this->validate();
    }

    #[Override]
    public function toBusRequest(): CommandInterface
    {
        return DestroyBook::fromString($this->resourceId);
    }

    protected function validate(): void
    {
        $this->requestValidator->validateBookId($this->resourceId);
    }
}
