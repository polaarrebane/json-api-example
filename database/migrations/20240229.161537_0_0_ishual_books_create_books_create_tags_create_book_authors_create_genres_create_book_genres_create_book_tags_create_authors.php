<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmIshualBooksFed1ea1d902a32562310fb3e1cb2750b extends Migration
{
    protected const DATABASE = 'ishual_books';

    public function up(): void
    {
        $this->table('books')
        ->addColumn('uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid', 'size' => 36])
        ->addColumn('title', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('description', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('cover', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->setPrimaryKeys(['uuid'])
        ->create();
        $this->table('tags')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('value', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addIndex(['value'], ['name' => 'tags_index_value_65e0ada96d909', 'unique' => true])
        ->setPrimaryKeys(['id'])
        ->create();
        $this->table('authors')
        ->addColumn('uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'id', 'size' => 36])
        ->addColumn('name', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->setPrimaryKeys(['uuid'])
        ->create();
        $this->table('book_authors')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('book_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid', 'size' => 36])
        ->addColumn('author_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'id', 'size' => 36])
        ->addIndex(['book_uuid', 'author_uuid'], [
            'name' => 'book_authors_index_book_uuid_author_uuid_65e0ada96d841',
            'unique' => true,
        ])
        ->addIndex(['book_uuid'], ['name' => 'book_authors_index_book_uuid_65e0ada96d855', 'unique' => false])
        ->addIndex(['author_uuid'], ['name' => 'book_authors_index_author_uuid_65e0ada96d86b', 'unique' => false])
        ->addForeignKey(['book_uuid'], 'books', ['uuid'], [
            'name' => 'book_authors_book_uuid_fk',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->addForeignKey(['author_uuid'], 'authors', ['uuid'], [
            'name' => 'book_authors_author_uuid_fk',
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
        ->addIndex(['abbreviation'], ['name' => 'genres_index_abbreviation_65e0ada96d935', 'unique' => true])
        ->setPrimaryKeys(['id'])
        ->create();
        $this->table('book_genres')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('book_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid', 'size' => 36])
        ->addColumn('genre_id', 'integer', ['nullable' => false, 'defaultValue' => null])
        ->addIndex(['book_uuid', 'genre_id'], [
            'name' => 'book_genres_index_book_uuid_genre_id_65e0ada96d7a9',
            'unique' => true,
        ])
        ->addIndex(['book_uuid'], ['name' => 'book_genres_index_book_uuid_65e0ada96d7be', 'unique' => false])
        ->addIndex(['genre_id'], ['name' => 'book_genres_index_genre_id_65e0ada96d7d5', 'unique' => false])
        ->addForeignKey(['book_uuid'], 'books', ['uuid'], [
            'name' => 'book_genres_book_uuid_fk',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->addForeignKey(['genre_id'], 'genres', ['id'], [
            'name' => 'book_genres_genre_id_fk',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->setPrimaryKeys(['id'])
        ->create();
        $this->table('book_tags')
        ->addColumn('id', 'primary', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('book_uuid', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'uuid', 'size' => 36])
        ->addColumn('tag_id', 'integer', ['nullable' => false, 'defaultValue' => null])
        ->addIndex(['book_uuid', 'tag_id'], ['name' => 'book_tags_index_book_uuid_tag_id_65e0ada96d636', 'unique' => true])
        ->addIndex(['book_uuid'], ['name' => 'book_tags_index_book_uuid_65e0ada96d71d', 'unique' => false])
        ->addIndex(['tag_id'], ['name' => 'book_tags_index_tag_id_65e0ada96d739', 'unique' => false])
        ->addForeignKey(['book_uuid'], 'books', ['uuid'], [
            'name' => 'book_tags_book_uuid_fk',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->addForeignKey(['tag_id'], 'tags', ['id'], [
            'name' => 'book_tags_tag_id_fk',
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
