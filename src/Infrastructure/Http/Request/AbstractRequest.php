<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use CuyZ\Valinor\Mapper\Source\JsonSource;
use CuyZ\Valinor\Mapper\Tree\Message\MessageBuilder;
use CuyZ\Valinor\MapperBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

abstract class AbstractRequest implements RequestInterface
{
    public static function fromServerRequest(ServerRequestInterface $request): static
    {
        return (new MapperBuilder())
            ->filterExceptions(function (Throwable $exception) {
                if ($exception instanceof InvalidArgumentException) {
                    return MessageBuilder::from($exception);
                }
                throw $exception;
            })
            ->mapper()
            ->map(
                static::class,
                new JsonSource($request->getBody()->getContents())
            );
    }

    /**
     * @param string[] $tags
     * @return void
     */
    protected function validateArrayOfTags(array $tags): void
    {
        array_walk(
            $tags,
            static function (string $tag) {
                Assert::alnum($tag);
                Assert::lower($tag);
            }
        );
    }

    /**
     * @param string[] $authorIds
     * @return void
     */
    protected function validateArrayOfAuthorIds(array $authorIds): void
    {
        array_walk(
            $authorIds,
            static function (string $authorId) {
                Assert::uuid($authorId);
            }
        );
    }
}
