<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book\UpdateBookRequest\Component;

final class Resource
{
    public string $type;
    public string $id;
    public ?Attributes $attributes = null;
    public ?Relationships $relationships = null;
}
