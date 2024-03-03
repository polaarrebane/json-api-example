<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Query\RetrieveBook;
use App\Infrastructure\Http\Request\Book\CreateBookRequest\CreateBookRequest;
use App\Infrastructure\Http\Request\Book\DeleteBookRequest\DeleteBookRequest;
use App\Infrastructure\Http\Request\Book\ListBooksRequest\ListBooksRequest;
use App\Infrastructure\Http\Request\Book\ReadBookRequest\ReadBookRequest;
use App\Infrastructure\Http\Request\Book\UpdateBookRequest\UpdateBookRequest;
use App\Infrastructure\Http\Response\Book\BookCollectionResponse;
use App\Infrastructure\Http\Response\Book\BookCreatedResponse;
use App\Infrastructure\Http\Response\Book\BookResponse;
use DI\Attribute\Inject;
use DI\Container;
use League\Config\Configuration;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode\RFC\RFC7231;

class BookController extends AbstractController
{
    #[Inject]
    protected Configuration $config;

    #[Inject]
    protected Container $container;

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $createBookRequest = $this->container->make(CreateBookRequest::class, ['serverRequest' => $request]);
        $createdBookId = $this->commandBus->send($createBookRequest->toBusRequest());
        $bookDto = $this->queryBus->send(RetrieveBook::fromString($createdBookId));

        return $this->container->make(BookCreatedResponse::class)
            ->withResource($bookDto)
            ->toPsrResponse()
            ->withStatus(RFC7231::CREATED);
    }

    public function list(BookCollectionResponse $bookResponse): ResponseInterface
    {
        $listBookRequest = $this->container->make(ListBooksRequest::class);
        $bookDtoCollection = $this->queryBus->send($listBookRequest->toBusRequest());

        return $bookResponse
            ->withCollection($bookDtoCollection)
            ->toPsrResponse();
    }

    public function read(ServerRequestInterface $request, string $id): ResponseInterface
    {
        $readBookRequest = $this->container->make(
            ReadBookRequest::class,
            ['serverRequest' => $request->withAttribute('resource_id', $id)]
        );

        $bookDto = $this->queryBus->send($readBookRequest->toBusRequest());

        return $this->container->make(BookResponse::class)
            ->withResource($bookDto)
            ->toPsrResponse();
    }

    public function update(ServerRequestInterface $request, string $id): ResponseInterface
    {
        $updateBookRequest = $this->container->make(
            UpdateBookRequest::class,
            ['serverRequest' => $request->withAttribute('resource_id', $id)]
        );
        $command = $updateBookRequest->toBusRequest();
        $this->commandBus->send($command);
        $bookDto = $this->queryBus->send(RetrieveBook::fromString($id));

        return $this->container->make(BookResponse::class)
            ->withResource($bookDto)
            ->toPsrResponse()
            ->withStatus(RFC7231::ACCEPTED);
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, string $id): ResponseInterface
    {
        $deleteBookRequest = $this->container->make(
            DeleteBookRequest::class,
            ['serverRequest' => $request->withAttribute('resource_id', $id)]
        );

        $this->commandBus->send($deleteBookRequest->toBusRequest());

        return $response->withStatus(RFC7231::NO_CONTENT);
    }
}
