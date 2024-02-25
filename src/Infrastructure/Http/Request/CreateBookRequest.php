<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Application\Command\AddNewBook;
use App\Application\Command\CommandInterface;
use App\Domain\ValueObject\GenreEnum;

final class CreateBookRequest extends AbstractRequest
{
    public function __construct(
        /** @var non-empty-string */
        private string $title,
        /** @var non-empty-string */
        private string $description,
        /** @var non-empty-string */
        private string $cover,
        /** @var non-empty-list<string> */
        private array $authors,
        /** @var non-empty-list<GenreEnum> */
        private array $genres,
        /** @var non-empty-list<string> */
        private array $tags,
    ) {
        $this->validateArrayOfTags($this->tags);
        $this->validateArrayOfAuthorIds($this->authors);
    }

    public function toCommand(): CommandInterface
    {
        return new AddNewBook(
            title: $this->title,
            description: $this->description,
            cover: $this->cover,
            authors: $this->authors,
            genres: array_map(static fn(GenreEnum $genreEnum) => $genreEnum->value, $this->genres),
            tags: $this->tags,
        );
    }

    /**
     * @return string[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }
}
