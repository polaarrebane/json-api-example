<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Factory;

use App\Infrastructure\Http\Request\RequestInterface;
use App\Infrastructure\Http\Validator\RequestValidator;
use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\Tree\Message\MessageBuilder;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use JsonException;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Webmozart\Assert\InvalidArgumentException;

class RequestFactory
{
    protected ?TreeMapper $treeMapper = null;

    public function __construct(
        protected RequestValidator $requestValidator,
    ) {
    }

    /**
     * @template T of RequestInterface
     * @param class-string<T> $className
     * @param ServerRequestInterface $serverRequest
     * @return T
     * @throws MappingError
     * @throws JsonException
     */
    public function make(string $className, ServerRequestInterface $serverRequest): RequestInterface
    {
        $newRequest = $this->mapper()->map($className, $this->source($serverRequest));
        $this->requestValidator->validate($newRequest);
        return  $newRequest;
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
            $builder->filterExceptions(function (Throwable $exception) {
                if ($exception instanceof InvalidArgumentException) {
                    return MessageBuilder::from($exception);
                }
                throw $exception;
            });
            $this->treeMapper = $builder->mapper();
        }

        return $this->treeMapper;
    }
}
