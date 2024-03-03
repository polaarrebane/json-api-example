<?php

declare(strict_types=1);

namespace Tests\Functional\Author;

use App\Application\Command\ModifyAuthor;
use App\Domain\ValueObject\AuthorId;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Tests\Support\FunctionalTester;

#[Group('author')]
class UpdateAuthorCest
{
    #[DataProvider('authorProvider')]
    public function tryToUpdateAuthor(FunctionalTester $I, \Codeception\Example $example): void
    {
        $I->haveInDatabase('authors', [
            'uuid' => $example['uuid'],
            'name' => $example['old_name'],
        ]);

        $command = new ModifyAuthor(
            AuthorId::fromString($example['uuid']),
            name: $example['new_name'],
        );

        $I->sendCommand($command);

        $I->seeInDatabase('authors', [
            'uuid' => $example['uuid'],
            'name' => $example['new_name'],
        ]);
    }

    protected function authorProvider(): array
    {
        return [
            [
                'uuid' => '8ef0bf00-e2b6-4a2b-8bda-a209e8eaefc2',
                'old_name' => 'John Ronald Reuel Tolkien',
                'new_name' => 'George Raymond Richard Martin',
            ],
        ];
    }
}
