<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Validator;

use App\Domain\ValueObject\GenreEnum;
use App\Infrastructure\Http\Request\Component\RelationshipItem;
use App\Infrastructure\Http\Request\CreateBookRequest;
use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Service\AuthorServiceInterface;
use League\Config\Configuration;
use Webmozart\Assert\Assert;

class RequestValidator
{
    public function __construct(
        AuthorServiceInterface $authorService,
        protected Configuration $config,
    ) {
    }

    public function validate(RequestInterface $request): void
    {
        match ($request::class) {
            CreateBookRequest::class => $this->validateCreateBookRequest($request)
        };
    }

    protected function validateCreateBookRequest(CreateBookRequest $request): void
    {
        $this->validateBookRequest($request);
    }

    protected function validateBookRequest(CreateBookRequest $request): void
    {
        Assert::eq($request->type, Type::BOOKS->value, 'Type should be "' . Type::BOOKS->value . '"');

        $this->validateCover($request->attributes->cover);
        $this->validateTags($request->attributes->tags);
        $this->validateAuthors($request->relationships->authors->data);
        $this->validateGenres($request->relationships->genres->data);
    }

    protected function validateCover(string $cover): void
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
    protected function validateAuthors(array $authorIds): void
    {
        foreach ($authorIds as $author) {
            Assert::eq(
                $author->type,
                Type::AUTHORS->value,
                'Type of item should be "' . Type::AUTHORS->value . '"'
            );
            Assert::uuid($author->id, 'An ID of an author should be a valid uuid');
        }
    }

    /**
     * @param RelationshipItem[] $genres
     * @return void
     */
    protected function validateGenres(array $genres): void
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
    protected function validateTags(array $tags): void
    {
        foreach ($tags as $tag) {
            Assert::alnum($tag, 'Tag should be alphabetical-numeral');
            Assert::lower($tag, 'Tag should be in a lower case');
        }
    }
}
