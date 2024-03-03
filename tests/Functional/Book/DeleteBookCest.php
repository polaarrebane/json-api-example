<?php

declare(strict_types=1);

namespace Tests\Functional\Book;

use App\Application\Command\DestroyBook;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Tests\Support\FunctionalTester;

#[Group('book')]
class DeleteBookCest
{
    use StoreBookTrait;

    #[DataProvider('bookProvider')]
    public function tryToDeleteBook(FunctionalTester $I, \Codeception\Example $example): void
    {
        $this->store($I, $example);
        $bookId = $example['uuid'];
        $I->sendCommand(DestroyBook::fromString($bookId));
        $I->dontSeeInDatabase('books', ['uuid' => $bookId]);
    }

    protected function bookProvider(): array
    {
        return [
            'Game of Thrones, or There and Back Again' => [
                'uuid' => '89302b6f-4749-44b9-aa6a-9e0c5cc7477c',
                'title' => 'Game of Thrones, or There and Back Again',
                'description' => <<<Description
                                In this ingenious fusion of epic fantasy and adventure, renowned author J.R.R. Martolkien 
                                weaves a tale that traverses realms, blending the intricate politics of Westeros with 
                                the whimsical adventures of the Shire. "Game of Thrones, or There and Back Again" transports
                                readers to a world where dragons soar overhead and hobbits tread cautiously through the lush
                                greenery of their homeland.
                                
                                From the scheming halls of King's Landing to the quaint villages of the Shire, the journey 
                                is fraught with danger, hilarity, and the occasional misplaced wizard. Along the way, our 
                                heroes encounter a colorful cast of characters, including a talking direwolf with a penchant
                                for sarcasm and a band of bumbling knights whose loyalty is matched only by their ineptitude.    
                                Description,
                'cover' => 'http://localhost/images/covers/1.webp',
                'authors_data' => [
                    [
                        'uuid' => '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
                        'name' => 'John Ronald Reuel Tolkien',
                    ],
                    [
                        'uuid' => '0994e049-8c39-426a-aa05-6daceb4ebf8b',
                        'name' => 'George Raymond Richard Martin',
                    ]
                ],
                'authors' => [
                    '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
                    '0994e049-8c39-426a-aa05-6daceb4ebf8b',
                ],
                'genres' => [
                    'sf_action',
                    'sf_fantasy',
                ],
                'tags' => [
                    'martolkien',
                    'journey'
                ]
            ]
        ];
    }
}
