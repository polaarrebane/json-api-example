<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\Tree\Message\MessageBuilder;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use JsonException;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Webmozart\Assert\InvalidArgumentException;

class Mapper
{
    protected ?TreeMapper $treeMapper = null;

    /**
     * @template T of object
     * @param class-string<T> $className
     * @param ServerRequestInterface $serverRequest
     * @return T
     * @throws MappingError
     * @throws JsonException
     */
    public function map(string $className, ServerRequestInterface $serverRequest): object
    {
        return $this->mapper()->map($className, $this->source($serverRequest));
    }

    protected function source(ServerRequestInterface $request): Source
    {
        $requestData = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        return Source::array($requestData['data']);
    }

    protected function mapper(): TreeMapper
    {
        if (is_null($this->treeMapper)) {
            $builder = new MapperBuilder();
            $this->treeMapper = $builder
                ->filterExceptions(function (Throwable $exception) {
                    if ($exception instanceof InvalidArgumentException) {
                        return MessageBuilder::from($exception);
                    }
                    throw $exception;
                })
                ->allowSuperfluousKeys()
                ->enableFlexibleCasting()
                ->mapper();
        }

        return $this->treeMapper;
    }
}
