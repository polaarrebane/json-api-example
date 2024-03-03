<?php

declare(strict_types=1);

namespace Tests\Functional\Book;

use App\Application\Command\ModifyBook;
use App\Domain\ValueObject\BookId;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Tests\Support\FunctionalTester;

#[Group('book')]
class UpdateBookCest
{
    use StoreBookTrait;

    public function _before(FunctionalTester $I)
    {
        foreach ($this->bookProvider() as $book) {
            $this->store($I, ['uuid' => $book['uuid']] + $book['old'] + ['authors_data' => $book['authors_data']]);
        }
    }

    #[DataProvider('attributesProvider')]
    public function tryToUpdateAttributesOfBook(FunctionalTester $I, \Codeception\Example $example): void
    {
        foreach ($this->bookProvider() as $book) {
            $bookId = $book['uuid'];
            $fields = array_intersect_key($book['new'], array_flip($example['fields']));
            $command = new ModifyBook(BookId::fromString($bookId), ...$fields);

            $I->sendCommand($command);

            $bookEntry = $I->grabEntryFromDatabase('books', ['uuid' => $bookId]);

            foreach ($fields as $field => $value) {
                $I->assertEquals($value, $bookEntry[$field]);
            }
        }
    }

    #[DataProvider('authorsProvider')]
    public function tryToUpdateAuthors(FunctionalTester $I, \Codeception\Example $example): void
    {
        foreach ($this->bookProvider() as $book) {
            $bookId = $book['uuid'];
            $command = new ModifyBook(BookId::fromString($bookId), authors: $example['authors']);

            $I->sendCommand($command);

            $entries = $I->grabEntriesFromDatabase('book_authors', ['book_uuid' => $bookId]);

            $I->assertEqualsCanonicalizing($example['authors'], array_column($entries, 'author_uuid'));
        }
    }

    #[DataProvider('genresProvider')]
    public function tryToUpdateGenres(FunctionalTester $I, \Codeception\Example $example): void
    {
        foreach ($this->bookProvider() as $book) {
            $bookId = $book['uuid'];
            $command = new ModifyBook(BookId::fromString($bookId), genres: $example['genres']);

            $I->sendCommand($command);

            $expectedBookGenreIds = [];
            foreach ($example['genres'] as $abbreviation) {
                $id = $I->grabFromDatabase('genres', 'id', ['abbreviation' => $abbreviation]);
                $expectedBookGenreIds[] = $id;
            }

            $entries = $I->grabEntriesFromDatabase('book_genres', ['book_uuid' => $bookId]);

            $I->assertEqualsCanonicalizing($expectedBookGenreIds, array_column($entries, 'genre_id'));
        }
    }

    #[DataProvider('tagsProvider')]
    public function tryToUpdateTags(FunctionalTester $I, \Codeception\Example $example): void
    {
        foreach ($this->bookProvider() as $book) {
            $bookId = $book['uuid'];
            $command = new ModifyBook(BookId::fromString($bookId), tags: $example['tags']);

            $I->sendCommand($command);

            $expectedBookTagIds = [];
            foreach ($example['tags'] as $value) {
                $id = $I->grabFromDatabase('tags', 'id', ['value' => $value]);
                $expectedBookTagIds[] = $id;
            }

            $entries = $I->grabEntriesFromDatabase('book_tags', ['book_uuid' => $bookId]);

            $I->assertEqualsCanonicalizing($expectedBookTagIds, array_column($entries, 'tag_id'));
        }
    }

    protected function attributesProvider(): array
    {
        return [
            'title' => ['fields' => ['title']],
            'description' => ['fields' => ['description']],
            'cover' => ['fields' => ['cover']],
            'all' => ['fields' => ['title', 'description', 'cover']],
        ];
    }

    protected function tagsProvider(): array
    {
        return [
            ['tags' => ['aperiam', 'laborum', 'temporibus',]],
            ['tags' => ['fugit', 'facere', 'nobis', 'quos', 'nihil']],
            ['tags' => ['fugit', 'aperiam', 'ut',]],
            ['tags' => []],
            ['tags' => ['fuga']],
        ];
    }

    protected function authorsProvider(): array
    {
        return [
            'Martin' => ['authors' => [
                '0994e049-8c39-426a-aa05-6daceb4ebf8b',
            ]],
            'Martin_and_Bakker' => ['authors' => [
                '0994e049-8c39-426a-aa05-6daceb4ebf8b',
                '9da5ceb1-3bcc-481c-838d-247b6544c5d9'
            ]],
            'Tolkien' => ['authors' => [
                '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
            ]],
            'all' => ['authors' => [
                '0994e049-8c39-426a-aa05-6daceb4ebf8b',
                '9da5ceb1-3bcc-481c-838d-247b6544c5d9',
                '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
            ]]
        ];
    }

    protected function genresProvider(): array
    {
        return [
            ['genres' => [
                'sf_action',
            ]],
            ['genres' => [
                'sf_epic',
            ]],
            ['genres' => [
                'sf_fantasy', 'sf', 'poetry', 'thriller'
            ]],
        ];
    }

    protected function bookProvider(): array
    {
        return [
            'Game of Thrones, or There and Back Again' => [
                'uuid' => '89302b6f-4749-44b9-aa6a-9e0c5cc7477c',
                'authors_data' => [
                    [
                        'uuid' => '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
                        'name' => 'John Ronald Reuel Tolkien',
                    ],
                    [
                        'uuid' => '0994e049-8c39-426a-aa05-6daceb4ebf8b',
                        'name' => 'George Raymond Richard Martin',
                    ],
                    [
                        'uuid' => '9da5ceb1-3bcc-481c-838d-247b6544c5d9',
                        'name' => 'Richard Scott Bakker',
                    ]
                ],
                'old' => [
                    'title' => 'Game of Thrones',
                    'description' => <<<Description
                                In this ingenious fusion of epic fantasy and adventure, renowned author J.R.R. Martolkien 
                                weaves a tale that traverses realms, blending the intricate politics of Westeros with 
                                the whimsical adventures of the Shire. "Game of Thrones, or There and Back Again" transports
                                readers to a world where dragons soar overhead and hobbits tread cautiously through the lush
                                greenery of their homeland.  
                                Description,
                    'cover' => 'http://localhost/images/covers/1.webp',
                    'authors' => [
                        '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2'
                    ],
                    'genres' => [
                        'sf_action',
                    ],
                    'tags' => [
                        'martolkien',
                    ]
                ],

                'new' => [
                    'title' => 'There and Back Again',
                    'description' => <<<Description
                                From the scheming halls of King's Landing to the quaint villages of the Shire, the journey 
                                is fraught with danger, hilarity, and the occasional misplaced wizard. Along the way, our 
                                heroes encounter a colorful cast of characters, including a talking direwolf with a penchant
                                for sarcasm and a band of bumbling knights whose loyalty is matched only by their ineptitude.    
                                Description,
                    'cover' => 'http://localhost/images/covers/2.webp',
                ]
            ]
        ];
    }
}
