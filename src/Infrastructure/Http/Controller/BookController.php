<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Query\RetrieveAuthorsOfBooks;
use App\Application\Query\RetrieveBook;
use App\Application\Query\RetrieveGenresOfBooks;
use App\Infrastructure\Http\Request\Book\BookRequest;
use App\Infrastructure\Http\Request\Book\CreateBookRequest\CreateBookRequest;
use App\Infrastructure\Http\Request\Book\DeleteBookRequest\DeleteBookRequest;
use App\Infrastructure\Http\Request\Book\ListBooksRequest\ListBooksRequest;
use App\Infrastructure\Http\Request\Book\ReadBookRequest\ReadBookRequest;
use App\Infrastructure\Http\Request\Book\UpdateBookRequest\UpdateBookRequest;
use App\Infrastructure\Http\Response\ApiResponseInterface;
use App\Infrastructure\Http\Response\Book\CollectionOfBooksResponse;
use App\Infrastructure\Http\Response\Book\CreateBookResponse;
use App\Infrastructure\Http\Response\Book\DeleteBookResponse;
use App\Infrastructure\Http\Response\Book\SingleBookResponse;
use App\Infrastructure\Http\Response\Book\UpdateBookResponse;

class BookController extends AbstractController
{
    public function create(CreateBookRequest $createBookRequest, CreateBookResponse $bookResponse): ApiResponseInterface
    {
        $createdBookId = $this->commandBus->send($createBookRequest->toBusRequest());
        $bookDto = $this->queryBus->send(RetrieveBook::fromString($createdBookId));
        $bookResponse->setResource($bookDto);
        $this->includeResources($createBookRequest, $bookResponse);

        return $bookResponse;
    }

    public function list(ListBooksRequest $listBookRequest, CollectionOfBooksResponse $bookResponse): ApiResponseInterface
    {
        $bookDtoCollection = $this->queryBus->send($listBookRequest->toBusRequest());
        $bookResponse->setCollection($bookDtoCollection);
        $this->includeResources($listBookRequest, $bookResponse);

        return $bookResponse;
    }

    public function read(ReadBookRequest $readBookRequest, SingleBookResponse $bookResponse): ApiResponseInterface
    {
        $bookDto = $this->queryBus->send($readBookRequest->toBusRequest());
        $bookResponse->setResource($bookDto);
        $this->includeResources($readBookRequest, $bookResponse);

        return $bookResponse;
    }

    public function update(UpdateBookRequest $updateBookRequest, UpdateBookResponse $bookResponse): ApiResponseInterface
    {
        $this->commandBus->send($updateBookRequest->toBusRequest());
        $bookDto = $this->queryBus->send(RetrieveBook::fromString($updateBookRequest->getResourceId()));
        $bookResponse->setResource($bookDto);
        $this->includeResources($updateBookRequest, $bookResponse);

        return $bookResponse;
    }

    public function delete(DeleteBookRequest $deleteBookRequest, DeleteBookResponse $bookResponse): ApiResponseInterface
    {
        $this->commandBus->send($deleteBookRequest->toBusRequest());

        return $bookResponse;
    }

    protected function includeResources(
        BookRequest $bookRequest,
        SingleBookResponse|CollectionOfBooksResponse $bookResponse
    ): void {
        if ($bookRequest->shouldInclude('authors')) {
            $query = RetrieveAuthorsOfBooks::fromArrayOfString($bookResponse->resourceIds());
            $authorsOfBooks = $this->queryBus->send($query);
            $sparseFieldset = $bookRequest->getSparseFieldsets()['authors'] ?? null;
            $bookResponse->addAuthors($authorsOfBooks, $sparseFieldset);
        }

        if ($bookRequest->shouldInclude('genres')) {
            $query = RetrieveGenresOfBooks::fromArrayOfString($bookResponse->resourceIds());
            $genresOfBooks = $this->queryBus->send($query);
            $sparseFieldset = $bookRequest->getSparseFieldsets()['genres'] ?? null;
            $bookResponse->addGenres($genresOfBooks, $sparseFieldset);
        }
    }
}
