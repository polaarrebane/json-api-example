<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Query\RetrieveBook;
use App\Infrastructure\Http\Factory\RequestFactory;
use App\Infrastructure\Http\Request\CreateBookRequest;
use App\Infrastructure\Http\Response\BookSuccessResponse;
use App\Infrastructure\Http\Service\AuthorServiceInterface;
use League\Config\Configuration;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class BookController extends AbstractController
{
    public function __construct(
        protected AuthorServiceInterface $authorService,
        protected Configuration $config,
        protected RequestFactory $requestFactory,
    ) {
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $createBookRequest = $this->requestFactory->make(CreateBookRequest::class, $request);
        $createdBookId = $this->commandBus->send($createBookRequest->toCommand());
        $bookDto = $this->queryBus->send(RetrieveBook::fromBookId($createdBookId));

        return BookSuccessResponse::fromDto($bookDto, $response, $this->config)->toResponse();
    }
}
