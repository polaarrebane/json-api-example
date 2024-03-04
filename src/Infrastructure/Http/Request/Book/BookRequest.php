<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request\Book;

use App\Infrastructure\Http\Request\AbstractRequest;

abstract class BookRequest extends AbstractRequest
{
    protected array $allowedSparseFieldsets = [
        'authors' => [
            'name',
        ],
        'genres' => [
            'description',
        ],
    ];
}
