<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\CreateAuthorRequest;

use App\Application\Command\AddNewAuthor;
use App\Application\Command\CommandInterface;
use App\Infrastructure\Http\Request\AbstractRequest;
use App\Infrastructure\Http\Request\Author\CreateAuthorRequest\Component\Resource;
use App\Infrastructure\Http\Validator\Type;
use Webmozart\Assert\Assert;

final class CreateAuthorRequest extends AbstractRequest
{
    protected Resource $resource;

    protected string $type = Type::AUTHORS->value;

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
