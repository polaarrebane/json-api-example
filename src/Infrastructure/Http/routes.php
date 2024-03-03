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
    $slim->get('/authors/{id}', [AuthorController::class, 'read']);
    $slim->patch('/authors/{id}', [AuthorController::class, 'update']);
    $slim->delete('/authors/{id}', [AuthorController::class, 'delete']);

    $slim->get('/books', [BookController::class, 'list']);
    $slim->post('/books', [BookController::class, 'create']);
    $slim->get('/books/{id}', [BookController::class, 'read']);
    $slim->patch('/books/{id}', [BookController::class, 'update']);
    $slim->delete('/books/{id}', [BookController::class, 'delete']);

    $slim->get('/genres', [GenreController::class, 'list']);

    return $slim;
}
