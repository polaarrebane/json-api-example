<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controller\AuthorController;
use App\Infrastructure\Http\Controller\BookController;
use App\Infrastructure\Http\Controller\GenreController;
use Slim\App;

function routes(App $slim): App
{
    $slim->post('/authors', [AuthorController::class, 'create']);
    $slim->get('/authors', [AuthorController::class, 'list']);
    $slim->get('/authors/{resource_id}', [AuthorController::class, 'read']);
    $slim->patch('/authors/{resource_id}', [AuthorController::class, 'update']);
    $slim->delete('/authors/{resource_id}', [AuthorController::class, 'delete']);

    $slim->get('/books', [BookController::class, 'list']);
    $slim->post('/books', [BookController::class, 'create']);
    $slim->get('/books/{resource_id}', [BookController::class, 'read']);
    $slim->patch('/books/{resource_id}', [BookController::class, 'update']);
    $slim->delete('/books/{resource_id}', [BookController::class, 'delete']);

    $slim->get('/genres', [GenreController::class, 'list']);
    $slim->get('/genres/{resource_id}', [GenreController::class, 'read']);

    return $slim;
}
