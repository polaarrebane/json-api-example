<?php

declare(strict_types=1);

namespace Tests\Functional\Book;

use ArrayAccess;
use Tests\Support\FunctionalTester;

trait StoreBookTrait
{
    protected function store(FunctionalTester $I, array|ArrayAccess $book): void
    {
        $bookId = $book['uuid'];

        $I->haveInDatabase('books', [
            'uuid' => $bookId,
            'title' => $book['title'],
            'description' => $book['description'],
            'cover' => $book['cover'],
        ]);

        foreach ($book['authors_data'] as $author) {
            $I->haveInDatabase('authors', ['uuid' => $author['uuid'], 'name' => $author['name']]);
        }

        foreach ($book['authors'] as $id => $authorUuid) {
            $I->haveInDatabase('book_authors', ['id' => $id + 1, 'book_uuid' => $bookId, 'author_uuid' => $authorUuid]);
        }

        foreach ($book['genres'] as $genre) {
            $genreId = $I->grabFromDatabase('genres', 'id', ['abbreviation' => $genre]);
            $I->haveInDatabase('book_genres', ['book_uuid' => $bookId, 'genre_id' => $genreId]);
        }

        foreach ($book['tags'] as $id => $tag) {
            $I->haveInDatabase('tags', ['id' => $id + 1, 'value' => $tag]);
            $I->haveInDatabase('book_tags', ['book_uuid' => $bookId, 'tag_id' => $id + 1]);
        }

        $I->fixSequence('tags', 'id');
        $I->fixSequence('book_authors', 'id');
        $I->fixSequence('book_genres', 'id');
        $I->fixSequence('book_tags', 'id');
    }
}
