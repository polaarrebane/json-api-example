<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Query\RetrieveAuthor;
use App\Infrastructure\Http\Request\Author\CreateAuthorRequest\CreateAuthorRequest;
use App\Infrastructure\Http\Request\Author\DeleteAuthorRequest\DeleteAuthorRequest;
use App\Infrastructure\Http\Request\Author\ListAuthorsRequest\ListAuthorsRequest;
use App\Infrastructure\Http\Request\Author\ReadAuthorRequest\ReadAuthorRequest;
use App\Infrastructure\Http\Request\Author\UpdateAuthorRequest\UpdateAuthorRequest;
use App\Infrastructure\Http\Request\Book\DeleteBookRequest\DeleteBookRequest;
use App\Infrastructure\Http\Request\Book\ListBooksRequest\ListBooksRequest;
use App\Infrastructure\Http\Response\Author\AuthorCollectionResponse;
use App\Infrastructure\Http\Response\Author\AuthorCreatedResponse;
use App\Infrastructure\Http\Response\Author\AuthorResponse;
use DI\Attribute\Inject;
use DI\Container;
use League\Config\Configuration;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode\RFC\RFC7231;

class AuthorController extends AbstractController
{
    #[Inject]
    protected Configuration $config;

    #[Inject]
    protected Container $container;

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        /** @var CreateAuthorRequest $createAuthorRequest */
        $createAuthorRequest = $this->container->make(CreateAuthorRequest::class, ['serverRequest' => $request]);
        $createdAuthorId = $this->commandBus->send($createAuthorRequest->toBusRequest());
        $authorDto = $this->queryBus->send(RetrieveAuthor::fromString($createdAuthorId));

        return $this->container
            ->make(AuthorCreatedResponse::class)
            ->withResource($authorDto)
            ->toPsrResponse()
            ->withStatus(RFC7231::CREATED);
    }

    public function list(AuthorCollectionResponse $authorResponse): ResponseInterface
    {
        $listAuthorRequest = $this->container->make(ListAuthorsRequest::class);
        $authorDtoCollection = $this->queryBus->send($listAuthorRequest->toBusRequest());

        return $authorResponse
            ->withCollection($authorDtoCollection)
            ->toPsrResponse();
    }

    public function read(ServerRequestInterface $request, string $id): ResponseInterface
    {
        $readAuthorRequest = $this->container->make(
            ReadAuthorRequest::class,
            ['serverRequest' => $request->withAttribute('resource_id', $id)]
        );

        $authorDto = $this->queryBus->send($readAuthorRequest->toBusRequest());

        return $this->container->make(AuthorResponse::class)
            ->withResource($authorDto)
            ->toPsrResponse();
    }

    public function update(ServerRequestInterface $request, string $id): ResponseInterface
    {
        $updateAuthorRequest = $this->container->make(
            UpdateAuthorRequest::class,
            ['serverRequest' => $request->withAttribute('resource_id', $id)]
        );
        $command = $updateAuthorRequest->toBusRequest();
        $this->commandBus->send($command);
        $bookDto = $this->queryBus->send(RetrieveAuthor::fromString($id));

        return $this->container->make(AuthorResponse::class)
            ->withResource($bookDto)
            ->toPsrResponse()
            ->withStatus(RFC7231::ACCEPTED);
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, string $id): ResponseInterface
    {
        $deleteAuthorRequest = $this->container->make(
            DeleteAuthorRequest::class,
            ['serverRequest' => $request->withAttribute('resource_id', $id)]
        );

        $this->commandBus->send($deleteAuthorRequest->toBusRequest());

        return $response->withStatus(RFC7231::NO_CONTENT);
    }
}
