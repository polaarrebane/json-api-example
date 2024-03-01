<?php

declare(strict_types=1);

namespace Tests\Functional\Author;

use App\Infrastructure\Http\Service\AuthorServiceInterface;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Ramsey\Uuid\Uuid;
use Tests\Support\FunctionalTester;

#[Group('author')]
class ExistsAuthorCest
{
    #[DataProvider('authorProvider')]
    public function tryToCheckThatAuthorsExist(FunctionalTester $I, \Codeception\Example $example): void
    {
        foreach ($example['authors'] as $author) {
            $I->haveInDatabase('authors', [
                'uuid' => $author['uuid'],
                'name' => $author['name'],
            ]);
        }

        $authorsService = $I->container()->get(AuthorServiceInterface::class);
        $I->assertTrue($authorsService->exists(
            array_column($example['authors'], 'uuid')
        ));
    }

    public function tryToCheckThatAuthorsNotExist(FunctionalTester $I): void
    {
        $authorsService = $I->container()->get(AuthorServiceInterface::class);
        $I->assertFalse($authorsService->exists([Uuid::uuid4()->toString()]));
    }

    protected function authorProvider(): array
    {
        return
            [
                [
                    'authors' => [
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
                        ],
                    ]
                ],
            ];
    }
}
