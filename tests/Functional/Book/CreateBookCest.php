<?php

declare(strict_types=1);

namespace Tests\Functional\Book;

use App\Application\Command\AddNewBook;
use Codeception\Attribute\Group;
use Tests\Support\FunctionalTester;

#[Group('book')]
class CreateBookCest
{
    protected const string TOLKIEN = '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2';

    protected const string MARTIN = '0994e049-8c39-426a-aa05-6daceb4ebf8b';

    public function _before(FunctionalTester $I)
    {
        $I->haveInDatabase('authors', [
            'uuid' => self::TOLKIEN,
            'name' => 'John Ronald Reuel Tolkien',
        ]);

        $I->haveInDatabase('authors', [
            'uuid' => self::MARTIN,
            'name' => 'George Raymond Richard Martin',
        ]);
    }

    public function tryToCreateBook(FunctionalTester $I): void
    {
        $title = 'Game of Thrones, or There and Back Again';

        $description =
            <<<Description
        In this ingenious fusion of epic fantasy and adventure, renowned author J.R.R. Martolkien 
        weaves a tale that traverses realms, blending the intricate politics of Westeros with 
        the whimsical adventures of the Shire. "Game of Thrones, or There and Back Again" transports
        readers to a world where dragons soar overhead and hobbits tread cautiously through the lush
        greenery of their homeland.
        
        From the scheming halls of King's Landing to the quaint villages of the Shire, the journey 
        is fraught with danger, hilarity, and the occasional misplaced wizard. Along the way, our 
        heroes encounter a colorful cast of characters, including a talking direwolf with a penchant
        for sarcasm and a band of bumbling knights whose loyalty is matched only by their ineptitude.    
        Description;

        $cover = 'http://localhost/images/covers/1.webp';

        $id = $I->sendCommand(
            new AddNewBook(
                title: $title,
                description: $description,
                cover: $cover,
                authors: [
                    '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
                    '0994e049-8c39-426a-aa05-6daceb4ebf8b',
                ],
                genres: [
                    'sf_action',
                    'sf_fantasy',
                ],
                tags: [
                    'martolkien',
                    'journey'
                ]
            )
        );

        $I->seeInDatabase('books', [
            'uuid' => $id,
            'title' => $title,
            'description' => $description,
            'cover' => $cover,
        ]);

        $I->seeInDatabase('book_authors', [
            'book_uuid' => $id,
            'author_uuid' => self::TOLKIEN
        ]);

        $I->seeInDatabase('book_authors', [
            'book_uuid' => $id,
            'author_uuid' => self::MARTIN
        ]);

        $sfActionGenreId = $I->grabFromDatabase('genres', 'id', ['abbreviation' => 'sf_action']);
        $sfActionFantasyId = $I->grabFromDatabase('genres', 'id', ['abbreviation' => 'sf_fantasy']);

        $I->seeInDatabase('book_genres', [
            'book_uuid' => $id,
            'genre_id' => $sfActionGenreId
        ]);

        $I->seeInDatabase('book_genres', [
            'book_uuid' => $id,
            'genre_id' => $sfActionFantasyId
        ]);

        $I->seeInDatabase('tags', ['value' => 'journey']);
        $I->seeInDatabase('tags', ['value' => 'martolkien']);

        $journeyTagId = $I->grabFromDatabase('tags', 'id', ['value' => 'journey']);
        $martolkienTagId = $I->grabFromDatabase('tags', 'id', ['value' => 'martolkien']);

        $I->seeInDatabase('book_tags', [
            'book_uuid' => $id,
            'tag_id' => $journeyTagId
        ]);

        $I->seeInDatabase('book_tags', [
            'book_uuid' => $id,
            'tag_id' => $martolkienTagId
        ]);
    }
}
