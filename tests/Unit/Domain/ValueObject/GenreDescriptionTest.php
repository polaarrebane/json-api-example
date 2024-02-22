<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreDescription;
use App\Domain\ValueObject\GenreEnum;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class GenreDescriptionTest extends Unit
{
    protected UnitTester $tester;

    public function testIsEqualTo(): void
    {
        $genres = GenreEnum::cases();
        shuffle($genres);
        [$randomGenre1, $randomGenre2] = array_slice($genres, 0, 2);

        $genreDescription = GenreDescription::fromEnum($randomGenre1);
        $genreDescriptionClone = clone $genreDescription;
        $anotherGenreDescription = GenreDescription::fromEnum($randomGenre2);

        $this->assertTrue($genreDescription->isEqualTo($genreDescription));
        $this->assertTrue($genreDescription->isEqualTo($genreDescriptionClone));
        $this->assertFalse($genreDescription->isEqualTo($anotherGenreDescription));
    }

    public function testFromAbbreviation(): void
    {
        foreach (GenreEnum::cases() as $genre) {
            $genreAbbreviationStub = GenreAbbreviation::fromEnum($genre);
            $genreDescription = GenreDescription::fromAbbreviation($genreAbbreviationStub);
            $this->assertEquals($genre->description(), $genreDescription->get());
        }
    }
}
