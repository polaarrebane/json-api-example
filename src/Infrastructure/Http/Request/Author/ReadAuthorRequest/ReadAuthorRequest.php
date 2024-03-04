<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\ReadAuthorRequest;

use App\Application\Query\QueryInterface;
use App\Application\Query\RetrieveAuthor;
use App\Application\Query\RetrieveBook;
use App\Infrastructure\Http\Request\AbstractRequest;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use Override;
use Psr\Http\Message\ServerRequestInterface;

final class ReadAuthorRequest extends AbstractRequest
{
    protected string $resourceId;

    #[Override]
    public function toBusRequest(): QueryInterface
    {
        return RetrieveAuthor::fromString($this->resourceId);
    }

    protected function validate(): void
    {
        $this->requestValidator->validaAuthorId($this->resourceId);
    }
}
