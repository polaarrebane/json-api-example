<?php

declare(strict_types=1);

namespace Tests\Functional\Author;

use App\Application\Command\DestroyAuthor;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Tests\Support\FunctionalTester;

#[Group('author2')]
class DeleteAuthorCest
{
    #[DataProvider('authorProvider')]
    public function tryToDeleteAuthor(FunctionalTester $I): void
    {
        $martin = $this->authorProvider()['Martin'];
        $I->haveInDatabase('authors', ['uuid' => $martin['uuid'], 'name' => $martin['name']]);

        $command = DestroyAuthor::fromString($martin['uuid']);
        $I->sendCommand($command);

        $I->dontSeeInDatabase('authors', ['uuid' => $martin['uuid']]);
    }

    protected function authorProvider(): array
    {
        return [
            'Martin' => [
                'uuid' => '0994e049-8c39-426a-aa05-6daceb4ebf8b',
                'name' => 'George Raymond Richard Martin',
            ]
        ];
    }
}
