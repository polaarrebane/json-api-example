<?php

namespace Tests\Unit\Domain\Entity;

use App\Application\Command\AddNewGenre;
use App\Domain\Dto\GenreDto;
use App\Domain\Entity\Genre;
use App\Domain\Event\Genre\GenreWasCreated;
use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreDescription;
use App\Domain\ValueObject\GenreEnum;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class GenreTest extends Unit
{
    protected UnitTester $tester;

    public function _before(): void
    {
        $this->tester->ecotone()->discardRecordedMessages();
    }

    public function testToDto(): void
    {
        $testData = $this->tester->genre();
        $dto = new GenreDto($testData['abbreviation'], $testData['description']);

        /** @var Genre $genre */
        $genre = $testData['genre'];

        $this->assertEquals($dto, $genre->toDto());
    }

    public function testAdd(): void
    {
        $randomGenre = GenreEnum::cases()[array_rand(GenreEnum::cases())];

        $command = new AddNewGenre(
            abbreviation: $randomGenre->value,
        );

        $this->tester->ecotone()->sendCommand($command);

        $events = $this->tester->ecotone()->getRecordedEvents();
        $this->assertCount(1, $events);

        $event = $events[0];
        $this->assertInstanceOf(GenreWasCreated::class, $event);

        /** @var Genre $createdGenre */
        $createdGenre = $this->tester->ecotone()->getAggregate(
            className: Genre::class,
            identifiers: $event->getGenreAbbreviation(),
        );

        $this->assertEquals(
            expected: GenreAbbreviation::fromEnum($randomGenre),
            actual: $createdGenre->getGenreAbbreviation(),
        );

        $this->assertEquals(
            expected: GenreDescription::fromEnum($randomGenre),
            actual: $createdGenre->getGenreDescription(),
        );
    }
}
