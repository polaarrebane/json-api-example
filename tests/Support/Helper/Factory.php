<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Domain\Entity\Author;
use App\Domain\Entity\Book;
use App\Domain\Entity\Genre;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\AuthorName;
use App\Domain\ValueObject\BookCover;
use App\Domain\ValueObject\BookDescription;
use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\BookTitle;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreDescription;
use App\Domain\ValueObject\GenreEnum;
use App\Domain\ValueObject\TagValue;
use Ramsey\Uuid\Uuid;

class Factory extends \Codeception\Module
{
    protected readonly \Faker\Generator $faker;

    public function _initialize(): void
    {
        if (!isset($this->faker)) {
            $this->faker = \Faker\Factory::create();
        }
    }

    public function author(): array
    {
        $id = Uuid::uuid4()->toString();
        $name = $this->faker->name();
        $author = new Author(AuthorId::fromString($id), AuthorName::fromString($name));

        return ['author' => $author, 'id' => $id, 'name' => $name];
    }

    public function genre(): array
    {
        $randomGenre = GenreEnum::cases()[array_rand(GenreEnum::cases())];
        $abbreviation = $randomGenre->value;
        $description = $randomGenre->description();

        return [
            'genre' => new Genre(
                GenreAbbreviation::fromString($abbreviation),
                GenreDescription::fromEnum($randomGenre),
            ),
            'abbreviation' => $abbreviation,
            'description' => $description,
        ];
    }

    public function tag(): array
    {
        $tag = $this->faker->word();

        return [
            'tag' => TagValue::fromString($tag),
            'value' => $tag,
        ];
    }

    public function book(): array
    {
        $id = Uuid::uuid4()->toString();
        $title = $this->faker->sentence();
        $description = $this->faker->paragraphs(asText: true);
        $cover = $this->faker->imageUrl();

        $author = $this->author();
        $genre = $this->genre();
        $tag = $this->tag();

        return [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'cover' => $cover,
            'author' => $author,
            'genre' => $genre,
            'tag' => $tag,
            'book' => new Book(
                bookId: BookId::fromString($id),
                title: BookTitle::fromString($title),
                description: BookDescription::fromString($description),
                cover: BookCover::fromString($cover),
                authors: [$author['author']->getAuthorId()],
                genres: [$genre['genre']->getGenreAbbreviation()],
                tags: [$tag['tag']],
            ),
        ];
    }
}
