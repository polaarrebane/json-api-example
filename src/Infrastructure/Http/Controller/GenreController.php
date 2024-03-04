<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Infrastructure\Http\Request\Genre\ListGenresRequest\ListGenresRequest;
use App\Infrastructure\Http\Request\Genre\ReadGenreRequest\ReadGenreRequest;
use App\Infrastructure\Http\Response\ApiResponseInterface;
use App\Infrastructure\Http\Response\Genre\GenreCollectionResponse;
use App\Infrastructure\Http\Response\Genre\GenreResponse;
use Psr\Http\Message\ResponseInterface;

class GenreController extends AbstractController
{
    public function list(ListGenresRequest $listGenreRequest, GenreCollectionResponse $genreResponse): ApiResponseInterface
    {
        $genreDtoCollection = $this->queryBus->send($listGenreRequest->toBusRequest());
        $genreResponse->setCollection($genreDtoCollection);

        return $genreResponse;
    }

    public function read(ReadGenreRequest $readGenreRequest, GenreResponse $genreResponse): ApiResponseInterface
    {
        $genreDto = $this->queryBus->send($readGenreRequest->toBusRequest());
        $genreResponse->setResource($genreDto);

        return $genreResponse;
    }
}
