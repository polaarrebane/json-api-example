<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Query\RetrieveAuthor;
use App\Infrastructure\Http\Request\Author\CreateAuthorRequest\CreateAuthorRequest;
use App\Infrastructure\Http\Request\Author\DeleteAuthorRequest\DeleteAuthorRequest;
use App\Infrastructure\Http\Request\Author\ListAuthorsRequest\ListAuthorsRequest;
use App\Infrastructure\Http\Request\Author\ReadAuthorRequest\ReadAuthorRequest;
use App\Infrastructure\Http\Request\Author\UpdateAuthorRequest\UpdateAuthorRequest;
use App\Infrastructure\Http\Response\ApiResponseInterface;
use App\Infrastructure\Http\Response\Author\CollectionOfAuthorsResponse;
use App\Infrastructure\Http\Response\Author\CreateAuthorResponse;
use App\Infrastructure\Http\Response\Author\DeleteAuthorResponse;
use App\Infrastructure\Http\Response\Author\SingleAuthorResponse;
use App\Infrastructure\Http\Response\Author\UpdateAuthorResponse;

class AuthorController extends AbstractController
{
    public function create(CreateAuthorRequest $createAuthorRequest, CreateAuthorResponse $authorResponse): ApiResponseInterface
    {
        $createdAuthorId = $this->commandBus->send($createAuthorRequest->toBusRequest());
        $authorDto = $this->queryBus->send(RetrieveAuthor::fromString($createdAuthorId));
        $authorResponse->setResource($authorDto);

        return $authorResponse;
    }

    public function list(ListAuthorsRequest $listAuthorRequest, CollectionOfAuthorsResponse $authorResponse): ApiResponseInterface
    {
        $authorDtoCollection = $this->queryBus->send($listAuthorRequest->toBusRequest());
        $authorResponse->setCollection($authorDtoCollection);

        return $authorResponse;
    }

    public function read(ReadAuthorRequest $readAuthorRequest, SingleAuthorResponse $authorResponse): ApiResponseInterface
    {
        $authorDto = $this->queryBus->send($readAuthorRequest->toBusRequest());
        $authorResponse->setResource($authorDto);

        return $authorResponse;
    }

    public function update(UpdateAuthorRequest $updateAuthorRequest, UpdateAuthorResponse $authorResponse): ApiResponseInterface
    {
        $this->commandBus->send($updateAuthorRequest->toBusRequest());
        $bookDto = $this->queryBus->send(RetrieveAuthor::fromString($updateAuthorRequest->getResourceId()));
        $authorResponse->setResource($bookDto);

        return $authorResponse;
    }

    public function delete(DeleteAuthorRequest $deleteAuthorRequest, DeleteAuthorResponse $authorResponse): ApiResponseInterface
    {
        $this->commandBus->send($deleteAuthorRequest->toBusRequest());

        return $authorResponse;
    }
}
