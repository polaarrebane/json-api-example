<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\CreateAuthorRequest;

use App\Application\Command\AddNewAuthor;
use App\Application\Command\CommandInterface;
use App\Infrastructure\Http\Request\Author\CreateAuthorRequest\Component\Resource;
use App\Infrastructure\Http\Request\Mapper;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use App\Infrastructure\Http\Validator\Type;
use Psr\Http\Message\ServerRequestInterface;
use Webmozart\Assert\Assert;

final class CreateAuthorRequest implements RequestInterface
{
    protected Resource $resource;

    protected string $type = Type::AUTHORS->value;

    public function __construct(
        protected ServerRequestInterface $serverRequest,
        protected Mapper $mapper,
        protected RequestValidator $requestValidator,
    ) {
        $this->resource = $this->mapper->map(Resource::class, $serverRequest);
        $this->validate();
    }

    public function toBusRequest(): CommandInterface
    {
        return new AddNewAuthor(
            name: $this->resource->attributes->name,
        );
    }

    protected function validate(): void
    {
        Assert::eq($this->resource->type, $this->type, 'Type should be "' . $this->type . '"');
    }
}
