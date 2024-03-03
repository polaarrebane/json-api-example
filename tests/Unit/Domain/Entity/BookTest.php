<?php

namespace Tests\Unit\Domain\Entity;

use App\Application\Command\AddNewAuthor;
use App\Application\Command\AddNewBook;
use App\Application\Command\AddNewGenre;
use App\Application\Command\ModifyBook;
use App\Domain\Dto\BookDto;
use App\Domain\Entity\Book;
use App\Domain\Event\Book\BookWasCreated;
use App\Domain\ValueObject\AuthorId;
use App\Domain\ValueObject\BookCover;
use App\Domain\ValueObject\BookDescription;
use App\Domain\ValueObject\BookId;
use App\Domain\ValueObject\BookTitle;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreEnum;
use App\Domain\ValueObject\TagValue;
use Closure;
use Codeception\Attribute\DataProvider;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class BookTest extends Unit
{
    protected UnitTester $tester;

    public function _before(): void
    {
        $this->tester->ecotone()->discardRecordedMessages();
    }
    public function testToDto(): void
    {
        $testData = $this->tester->book();
        $dto = new BookDto(
            id: $testData['id'],
            title: $testData['title'],
            description: $testData['description'],
            cover: $testData['cover'],
            authors: [$testData['author']['id']],
            genres: [$testData['genre']['abbreviation']],
            tags: [$testData['tag']['value']],
        );

        /** @var Book $book */
        $book = $testData['book'];

        $this->assertEquals($dto, $book->toDto());
    }

    public function testAdd(): void
    {
        $title = $this->tester->faker()->sentence();
        /** @var string $description */
        $description = $this->tester->faker()->paragraphs(asText: true);
        $cover = $this->tester->faker()->imageUrl();

        $authors = array_map(
            fn() => $this->newAuthor(),
            array_fill(0, random_int(1, 5), 0)
        );

        $tags = array_map(
            fn() => $this->newTag(),
            array_fill(0, random_int(1, 5), 0),
        );

        $genres = [$this->newGenre()];

        $this->tester->ecotone()->sendCommand(
            new AddNewBook(
                title: $title,
                description: $description,
                cover: $cover,
                authors: array_map(static fn(AuthorId $authorId) => $authorId->get(), $authors),
                genres: array_map(static fn(GenreAbbreviation $abbreviation) => $abbreviation->get(), $genres),
                tags: array_map(static fn(TagValue $tag) => $tag->get(), $tags),
            )
        );

        $events = $this->tester->ecotone()->getRecordedEvents();
        $this->assertCount(1, $events);

        $event = $events[0];
        $this->assertInstanceOf(BookWasCreated::class, $event);

        /** @var Book $createdBook */
        $createdBook = $this->tester->ecotone()->getAggregate(
            className: Book::class,
            identifiers: $event->getBookId(),
        );

        $this->assertEquals(
            expected: BookTitle::fromString($title),
            actual: $createdBook->getTitle(),
        );

        $this->assertEquals(
            expected: BookDescription::fromString($description),
            actual: $createdBook->getDescription(),
        );

        $this->assertEquals(
            expected: BookCover::fromString($cover),
            actual: $createdBook->getCover(),
        );

        $this->assertEqualsCanonicalizing(
            expected: $authors,
            actual: $createdBook->getAuthors(),
        );

        $this->assertEqualsCanonicalizing(
            expected: $genres,
            actual: $createdBook->getGenres(),
        );

        $this->assertEqualsCanonicalizing(
            expected: $tags,
            actual: $createdBook->getTags(),
        );
    }

    #[DataProvider('dataProvider')]
    public function testModify(
        Closure $calculateCommand,
        Closure $calculateExpectedValue,
        Closure $calculateActualValue,
    ): void {
        $bookId = $this->newBook();

        $command = $calculateCommand($bookId);
        $this->tester->ecotone()->sendCommand($command);

        $book = $this->tester->ecotone()->getAggregate(
            className: Book::class,
            identifiers: $bookId,
        );

        $this->assertEqualsCanonicalizing(
            expected: $calculateExpectedValue($command),
            actual: $calculateActualValue($book),
        );
    }

    /**
     * @return Closure[][]
     */
    protected function dataProvider(): array
    {
        return [

            'modify title' => [
                'calculateCommand' => fn(BookId $bookId) => new ModifyBook(
                    bookId: $bookId,
                    title: 'Qui dolores ut alias et asperiores tempora est eligendi.',
                ),
                'calculateExpectedValue' => fn(ModifyBook $command) => [
                    BookTitle::fromString($command->title),
                ],
                'calculateActualValue' => fn(Book $book) => [$book->getTitle()],
            ],

            'modify description' => [
                'calculateCommand' => fn(BookId $bookId) => new ModifyBook(
                    bookId: $bookId,
                    description: 'Perspiciatis sint nihil architecto sequi fugiat ab similique consequatur.',
                ),
                'calculateExpectedValue' => fn(ModifyBook $command) => [
                    BookDescription::fromString($command->description),
                ],
                'calculateActualValue' => fn(Book $book) => [$book->getDescription()],
            ],

            'modify cover' => [
                'calculateCommand' => fn(BookId $bookId) => new ModifyBook(
                    bookId: $bookId,
                    cover: 'Facere quo dignissimos qui nemo nulla dolor cumque',
                ),
                'calculateExpectedValue' => fn(ModifyBook $command) => [BookCover::fromString($command->cover)],
                'calculateActualValue' => fn(Book $book) => [$book->getCover()],
            ],

            'modify authors' => [
                'calculateCommand' => fn(BookId $bookId) => new ModifyBook(
                    bookId: $bookId,
                    authors: [
                        AuthorId::fromUuid(),
                    ],
                ),
                'calculateExpectedValue' => fn(ModifyBook $command) => $command->authors,
                'calculateActualValue' => fn(Book $book) => $book->getAuthors(),
            ],

            'modify genres' => [
                'calculateCommand' => fn(BookId $bookId) => new ModifyBook(
                    bookId: $bookId,
                    genres: [
                        GenreAbbreviation::fromEnum(GenreEnum::adv_geo)->get(),
                        GenreAbbreviation::fromEnum(GenreEnum::antique)->get(),
                    ],
                ),
                'calculateExpectedValue' => fn(ModifyBook $command) => [
                    GenreAbbreviation::fromEnum(GenreEnum::adv_geo),
                    GenreAbbreviation::fromEnum(GenreEnum::antique)
                ],
                'calculateActualValue' => fn(Book $book) => $book->getGenres(),
            ],

            'modify tags' => [
                'calculateCommand' => fn(BookId $bookId) => new ModifyBook(
                    bookId: $bookId,
                    tags: ['some', 'tag'],
                ),
                'calculateExpectedValue' => fn(ModifyBook $command) => [
                    TagValue::fromString('some'),
                    TagValue::fromString('tag')
                ],
                'calculateActualValue' => fn(Book $book) => $book->getTags(),
            ],

        ];
    }

    protected function newAuthor(): AuthorId
    {
        $authorName = $this->tester->faker()->name();
        $this->tester->ecotone()->sendCommand(new AddNewAuthor($authorName));
        return $this->tester->ecotone()->getRecordedEvents()[0]->getAuthorId();
    }

    protected function newBook(): BookId
    {
        $title = $this->tester->faker()->sentence();
        /** @var string $description */
        $description = $this->tester->faker()->paragraphs(asText: true);
        $cover = $this->tester->faker()->imageUrl();

        $author = $this->newAuthor();
        $genre = $this->newGenre();
        $tag = $this->newTag();

        $this->tester->ecotone()->sendCommand(new AddNewBook(
            title: $title,
            description: $description,
            cover: $cover,
            authors: [$author->get()],
            genres: [$genre->get()],
            tags: [$tag->get()],
        ));

        return $this->tester->ecotone()->getRecordedEvents()[0]->getBookId();
    }

    protected function newGenre(): GenreAbbreviation
    {
        $randomGenre = GenreEnum::cases()[array_rand(GenreEnum::cases())];
        $abbreviation = $randomGenre->value;
        $this->tester->ecotone()->sendCommand(new AddNewGenre($abbreviation));
        return $this->tester->ecotone()->getRecordedEvents()[0]->getGenreAbbreviation();
    }

    protected function newTag(): TagValue
    {
        $tag = $this->tester->faker()->word();

        return TagValue::fromString($tag);
    }
}
