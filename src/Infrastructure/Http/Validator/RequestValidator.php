<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Validator;

use App\Domain\ValueObject\GenreEnum;
use App\Infrastructure\Http\Request\RelationshipItem;
use App\Infrastructure\Http\Service\AuthorServiceInterface;
use App\Infrastructure\Http\Service\BookServiceInterface;
use League\Config\Configuration;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class RequestValidator
{
    public function __construct(
        protected AuthorServiceInterface $authorService,
        protected BookServiceInterface $bookService,
        protected Configuration $config,
    ) {
    }

    public function validateBookId(string $bookId): void
    {
        Assert::true(Uuid::isValid($bookId), 'An ID of a book should be a valid uuid');
        Assert::true($this->bookService->exists($bookId), 'Book not found');
    }

    public function validateCover(string $cover): void
    {
        Assert::notFalse(
            filter_var($cover, FILTER_VALIDATE_URL),
            'Cover should be a valid url'
        );

        Assert::eq(
            parse_url($cover, PHP_URL_HOST),
            $this->config->get('app.image_hosting_service'),
            'Unknown image hosting service'
        );

        Assert::notEmpty(
            parse_url($cover, PHP_URL_PATH),
            'Empty cover path'
        );

        Assert::minLength(
            parse_url($cover, PHP_URL_PATH),
            2,
            'Incorrect cover path'
        );
    }

    /**
     * @param RelationshipItem[] $authorIds
     * @return void
     */
    public function validateAuthors(array $authorIds): void
    {
        foreach ($authorIds as $author) {
            Assert::eq(
                $author->type,
                Type::AUTHORS->value,
                'Type of item should be "' . Type::AUTHORS->value . '"'
            );
            Assert::uuid($author->id, 'An ID of an author should be a valid uuid');
        }

        Assert::true($this->authorService->exists(array_column($authorIds, 'id')), 'Author not found');
    }

    public function validaAuthorId(string $authorId): void
    {
        Assert::true(Uuid::isValid($authorId), 'An ID of an author should be a valid uuid');
        Assert::true($this->authorService->exists([$authorId]), 'Author not found');
    }

    /**
     * @param RelationshipItem[] $genres
     * @return void
     */
    public function validateGenres(array $genres): void
    {
        $knownGenres = GenreEnum::values();

        foreach ($genres as $genre) {
            Assert::eq($genre->type, Type::GENRES->value, 'Type of item should be "' . Type::GENRES->value . '"');
            Assert::oneOf($genre->id, $knownGenres, 'Unknown genre: ' . $genre->id);
        }
    }

    /**
     * @param string[] $tags
     * @return void
     */
    public function validateTags(array $tags): void
    {
        foreach ($tags as $tag) {
            Assert::alnum($tag, 'Tag should be alphabetical-numeral');
            Assert::lower($tag, 'Tag should be in a lower case');
        }
    }
}
