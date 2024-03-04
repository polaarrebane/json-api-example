<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response\Book;

use App\Domain\Dto\AuthorDto;
use App\Domain\Dto\GenreDto;
use App\Infrastructure\Http\Response\Author\SingleAuthorResponse;
use App\Infrastructure\Http\Response\Genre\GenreResponse;
use DI\DependencyException;
use DI\NotFoundException;

trait IncludeResourcesOfBook
{
    /**
     * @var mixed[]
     */
    protected array $included;

    /** @var array<string, string[]> */
    protected array $includedIds = [];

    /**
     * @param AuthorDto[] $authorDtos
     * @param string[]|null $sparseFieldset
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function addAuthors(array $authorDtos, ?array $sparseFieldset = null): void
    {
        $authorResponse = $this->container->make(SingleAuthorResponse::class);

        foreach ($authorDtos as $authorDto) {
            if (!isset($includedIds['authors'][$authorDto->id])) {
                $includedIds['authors'][$authorDto->id] = $authorDto->id;

                $includedData = $authorResponse->setResource($authorDto)->toArray(wrap: false);

                if (!is_null($sparseFieldset)) {
                    $includedData = $this->filterFields($includedData, $sparseFieldset);
                }

                $this->included[] = $includedData;
            }
        }
    }

    /**
     * @param GenreDto[] $genreDtos
     * @param string[]|null $sparseFieldset
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function addGenres(array $genreDtos, ?array $sparseFieldset = null): void
    {
        $genreResponse = $this->container->make(GenreResponse::class);

        foreach ($genreDtos as $genreDto) {
            if (!isset($includedIds['genres'][$genreDto->abbreviation])) {
                $includedIds['genres'][$genreDto->abbreviation] = $genreDto->abbreviation;

                $includedData = $genreResponse->setResource($genreDto)->toArray(wrap: false);

                if (!is_null($sparseFieldset)) {
                    $includedData = $this->filterFields($includedData, $sparseFieldset);
                }

                $this->included[] = $includedData;
            }
        }
    }

    /**
     * @param array<string,mixed> $data
     * @param string[] $fields
     * @return array<string,mixed>
     */
    protected function filterFields(array $data, array $fields): array
    {
        $result['type'] = $data['type'];
        $result['id'] = $data['id'];

        foreach ($fields as $field) {
            if (isset($data['attributes'][$field])) {
                $result['attributes'][$field] = $data['attributes'][$field];
            }

            if (isset($data['relationships'][$field])) {
                $result['relationships'][$field] = $data['relationships'][$field];
            }
        }

        return $result;
    }
}
