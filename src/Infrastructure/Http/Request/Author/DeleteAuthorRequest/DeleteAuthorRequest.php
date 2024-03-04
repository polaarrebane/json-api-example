<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\DeleteAuthorRequest;

use App\Application\Command\CommandInterface;
use App\Application\Command\DestroyAuthor;
use App\Infrastructure\Http\Request\AbstractRequest;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use Override;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteAuthorRequest extends AbstractRequest
{
    protected string $resourceId;

    #[Override]
    public function toBusRequest(): CommandInterface
    {
        return DestroyAuthor::fromString($this->resourceId);
    }

    protected function validate(): void
    {
        $this->requestValidator->validaAuthorId($this->resourceId);
    }
}
