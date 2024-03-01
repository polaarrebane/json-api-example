<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmIshualBooksE8e75642f58d144057826ce3c5afb8b0 extends Migration
{
    protected const DATABASE = 'ishual_books';

    public function up(): void
    {
        $this->table('books')
        ->addColumn('uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid'])
        ->addColumn('title', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('description', 'text', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('cover', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->setPrimaryKeys(['uuid'])
        ->create();
        $this->table('tags')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('value', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addIndex(['value'], ['name' => 'tags_index_value_65e221379458a', 'unique' => true])
        ->setPrimaryKeys(['id'])
        ->create();
        $this->table('authors')
        ->addColumn('uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid'])
        ->addColumn('name', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->setPrimaryKeys(['uuid'])
        ->create();
        $this->table('book_authors')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('book_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid'])
        ->addColumn('author_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid'])
        ->addIndex(['book_uuid', 'author_uuid'], [
            'name' => 'book_authors_index_book_uuid_author_uuid_65e2213794497',
            'unique' => true,
        ])
        ->addIndex(['book_uuid'], ['name' => 'book_authors_index_book_uuid_65e22137944af', 'unique' => false])
        ->addIndex(['author_uuid'], ['name' => 'book_authors_index_author_uuid_65e22137944c9', 'unique' => false])
        ->addForeignKey(['book_uuid'], 'books', ['uuid'], [
            'name' => 'book_authors_foreign_book_uuid_65e22137944a7',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->addForeignKey(['author_uuid'], 'authors', ['uuid'], [
            'name' => 'book_authors_foreign_author_uuid_65e22137944c0',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->setPrimaryKeys(['id'])
        ->create();
        $this->table('genres')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('abbreviation', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('description', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addIndex(['abbreviation'], ['name' => 'genres_index_abbreviation_65e22137945bb', 'unique' => true])
        ->setPrimaryKeys(['id'])
        ->create();
        $this->table('book_genres')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('book_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid'])
        ->addColumn('genre_id', 'integer', ['nullable' => false, 'defaultValue' => null])
        ->addIndex(['book_uuid', 'genre_id'], [
            'name' => 'book_genres_index_book_uuid_genre_id_65e22137943f1',
            'unique' => true,
        ])
        ->addIndex(['book_uuid'], ['name' => 'book_genres_index_book_uuid_65e221379440b', 'unique' => false])
        ->addIndex(['genre_id'], ['name' => 'book_genres_index_genre_id_65e2213794426', 'unique' => false])
        ->addForeignKey(['book_uuid'], 'books', ['uuid'], [
            'name' => 'book_genres_foreign_book_uuid_65e2213794402',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->addForeignKey(['genre_id'], 'genres', ['id'], [
            'name' => 'book_genres_foreign_genre_id_65e221379441d',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->setPrimaryKeys(['id'])
        ->create();
        $this->table('book_tags')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('book_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid'])
        ->addColumn('tag_id', 'integer', ['nullable' => false, 'defaultValue' => null])
        ->addIndex(['book_uuid', 'tag_id'], ['name' => 'book_tags_index_book_uuid_tag_id_65e2213794251', 'unique' => true])
        ->addIndex(['book_uuid'], ['name' => 'book_tags_index_book_uuid_65e221379434a', 'unique' => false])
        ->addIndex(['tag_id'], ['name' => 'book_tags_index_tag_id_65e2213794370', 'unique' => false])
        ->addForeignKey(['book_uuid'], 'books', ['uuid'], [
            'name' => 'book_tags_foreign_book_uuid_65e2213794265',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->addForeignKey(['tag_id'], 'tags', ['id'], [
            'name' => 'book_tags_foreign_tag_id_65e2213794365',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->setPrimaryKeys(['id'])
        ->create();
    }

    public function down(): void
    {
        $this->table('book_tags')->drop();
        $this->table('book_genres')->drop();
        $this->table('genres')->drop();
        $this->table('book_authors')->drop();
        $this->table('authors')->drop();
        $this->table('tags')->drop();
        $this->table('books')->drop();
    }
}
