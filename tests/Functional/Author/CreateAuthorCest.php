<?php

declare(strict_types=1);

namespace Tests\Functional\Author;

use App\Application\Command\AddNewAuthor;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Tests\Support\FunctionalTester;

#[Group('author')]
class CreateAuthorCest
{
    #[DataProvider('authorProvider')]
    public function tryToCreateAuthor(FunctionalTester $I, \Codeception\Example $example): void
    {
        $id = $I->sendCommand(new AddNewAuthor($example['name']));

        $I->seeInDatabase('authors', [
            'uuid' => $id,
            'name' => $example['name'],
        ]);
    }

    protected function authorProvider(): array
    {
        return [
            [
                'name' => 'John Ronald Reuel Tolkien',
            ],
            [
                'name' => 'George Raymond Richard Martin',
            ],
        ];
    }
}
