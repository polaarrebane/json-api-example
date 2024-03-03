<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Infrastructure\Http\Request\Genre\ListGenresRequest\ListGenresRequest;
use App\Infrastructure\Http\Response\Genre\GenreCollectionResponse;
use DI\Attribute\Inject;
use DI\Container;
use League\Config\Configuration;
use Psr\Http\Message\ResponseInterface;

class GenreController extends AbstractController
{
    #[Inject]
    protected Configuration $config;

    #[Inject]
    protected Container $container;

    public function list(GenreCollectionResponse $genreResponse): ResponseInterface
    {
        $listGenreRequest = $this->container->make(ListGenresRequest::class);
        $genreDtoCollection = $this->queryBus->send($listGenreRequest->toBusRequest());

        return $genreResponse
            ->withCollection($genreDtoCollection)
            ->toPsrResponse();
    }
}
