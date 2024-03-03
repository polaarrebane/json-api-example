<?php

namespace Tests\Unit\Domain\Entity;

use App\Application\Command\AddNewAuthor;
use App\Application\Command\ModifyAuthor;
use App\Domain\Dto\AuthorDto;
use App\Domain\Entity\Author;
use App\Domain\Event\Author\AuthorWasCreated;
use App\Domain\ValueObject\AuthorName;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class AuthorTest extends Unit
{
    protected UnitTester $tester;

    public function _before(): void
    {
        $this->tester->ecotone()->discardRecordedMessages();
    }

    public function testToDto(): void
    {
        $testData = $this->tester->author();
        $dto = new AuthorDto($testData['id'], $testData['name']);

        /** @var Author $author */
        $author = $testData['author'];

        $this->assertEquals($dto, $author->toDto());
    }

    public function testAdd(): void
    {
        $authorName = $this->tester->faker()->name();

        $command = new AddNewAuthor(
            name: $authorName,
        );

        $this->tester->ecotone()->sendCommand($command);

        $events = $this->tester->ecotone()->getRecordedEvents();
        $this->assertCount(1, $events);

        $event = $events[0];
        $this->assertInstanceOf(AuthorWasCreated::class, $event);

        /** @var Author $createdAuthor */
        $createdAuthor = $this->tester->ecotone()->getAggregate(
            className: Author::class,
            identifiers: $event->getAuthorId(),
        );

        $this->assertEquals(
            expected: AuthorName::fromString($authorName),
            actual: $createdAuthor->getAuthorName(),
        );
    }

    public function testModify(): void
    {
        $oldAuthorName = $this->tester->faker()->name();
        $newAuthorName = $this->tester->faker()->name();

        $this->tester->ecotone()->sendCommand(new AddNewAuthor(
            name: $oldAuthorName,
        ));
        $event = $this->tester->ecotone()->getRecordedEvents()[0];
        $authorId = $event->getAuthorId();

        $this->tester->ecotone()->sendCommand(new ModifyAuthor(
            authorId: $authorId,
            name: $newAuthorName,
        ));

        /** @var Author $author */
        $author = $this->tester->ecotone()->getAggregate(
            className: Author::class,
            identifiers: $authorId,
        );

        $this->assertEquals(
            expected: AuthorName::fromString($newAuthorName),
            actual: $author->getAuthorName(),
        );
    }
}
