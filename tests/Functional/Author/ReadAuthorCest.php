<?php

declare(strict_types=1);

namespace Tests\Functional\Author;

use App\Application\Query\RetrieveAuthor;
use App\Domain\Dto\AuthorDto;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Tests\Support\FunctionalTester;

#[Group('author')]
class ReadAuthorCest
{
    #[DataProvider('authorProvider')]
    public function tryToReadAuthor(FunctionalTester $I, \Codeception\Example $example): void
    {
        $I->haveInDatabase('authors', [
            'uuid' => $example['uuid'],
            'name' => $example['name'],
        ]);

        $command = RetrieveAuthor::fromString($example['uuid']);

        /** @var AuthorDto $authorDto */
        $authorDto = $I->sendQuery($command);

        $I->assertEquals($example['uuid'], $authorDto->id);
        $I->assertEquals($example['name'], $authorDto->name);
        $I->seeInDatabase('authors', ['uuid' => $example['uuid']]);
    }

    protected function authorProvider(): array
    {
        return [
            [
                'uuid' => '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
                'name' => 'John Ronald Reuel Tolkien',
            ],
        ];
    }
}
