<?php

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\GenreAbbreviation;
use App\Domain\ValueObject\GenreEnum;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;
use ValueError;

class GenreAbbreviationTest extends Unit
{
    protected UnitTester $tester;

    public function testFromString(): void
    {
        $genres = GenreEnum::cases();
        $randomGenre = $genres[array_rand($genres)];
        $genreAbbreviation = GenreAbbreviation::fromString($randomGenre->value);
        $this->assertSame($randomGenre->value, $genreAbbreviation->get());

        $this->expectException(ValueError::class);
        $invalidGenre = 'qwe123';
        GenreAbbreviation::fromString($invalidGenre);
    }

    public function testIsEqualTo(): void
    {
        $genres = GenreEnum::cases();
        shuffle($genres);
        [$randomGenre1, $randomGenre2] = array_slice($genres, 0, 2);

        $genreAbbreviation = GenreAbbreviation::fromEnum($randomGenre1);
        $genreAbbreviationClone = clone $genreAbbreviation;
        $anotherGenreAbbreviation = GenreAbbreviation::fromEnum($randomGenre2);

        $this->assertTrue($genreAbbreviation->isEqualTo($genreAbbreviation));
        $this->assertTrue($genreAbbreviation->isEqualTo($genreAbbreviationClone));
        $this->assertFalse($genreAbbreviation->isEqualTo($anotherGenreAbbreviation));
    }

    public function testGet(): void
    {
        $expectedGenresAbbreviations = array_column(GenreEnum::cases(), 'value');

        $actualGenresAbbreviations = [];

        foreach (GenreEnum::cases() as $genreEnum) {
            $actualGenresAbbreviations [] = GenreAbbreviation::fromEnum($genreEnum)->get();
        }

        $this->assertEqualsCanonicalizing($expectedGenresAbbreviations, $actualGenresAbbreviations);
    }
}
