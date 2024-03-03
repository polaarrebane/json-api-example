<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Author\CreateAuthorRequest\Component;

final class Resource
{
    public string $type;
    public Attributes $attributes;
    public Relationships $relationships;
}
