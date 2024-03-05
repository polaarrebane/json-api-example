<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use App\Infrastructure\Http\Exception\Include\EndpointDoesNotSupportInclusionOfResource;
use App\Infrastructure\Http\Exception\Include\EndpointDoesNotSupportTheIncludeParameter;
use App\Infrastructure\Http\Exception\Include\IncorrectInclusionField;
use App\Infrastructure\Http\Validator\RequestValidator;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionProperty;

abstract class AbstractRequest implements RequestInterface
{
    /** @var string[]  */
    protected array $canBeIncluded = [];

    /** @var array<string, string[]> */
    protected array $allowedSparseFieldsets = [];

    public function __construct(
        protected ServerRequestInterface $serverRequest,
        protected Mapper $mapper,
        protected RequestValidator $requestValidator,
    ) {
        if (property_exists($this, 'resource')) {
            $this->resource = $this->mapper->map(
                (new ReflectionProperty($this, 'resource'))->getType()->getName(),
                $serverRequest,
            );
        }

        if (property_exists($this, 'resourceId')) {
            $this->resourceId = $serverRequest->getAttribute('resource_id');
        }

        if (method_exists($this, 'validate')) {
            $this->validate();
        }

        $this->checkInclusion();
    }

    /**
     * @return array<string, string[]>
     */
    public function getSparseFieldsets(): array
    {
        return $this->serverRequest->getAttribute('sparse_fieldsets', []);
    }

    public function shouldInclude(string $relationshipName): bool
    {
        return in_array($relationshipName, $this->serverRequest->getAttribute('include', []), true);
    }

    protected function checkInclusion(): void
    {
        $include = $this->serverRequest->getAttribute('include', []);

        if (
            (empty($this->canBeIncluded)) &&
            !empty($this->serverRequest->getAttribute('include'))
        ) {
            throw new EndpointDoesNotSupportTheIncludeParameter($this->serverRequest);
        }

        if (!empty(array_diff($include, $this->canBeIncluded))) {
            throw new EndpointDoesNotSupportInclusionOfResource($this->serverRequest);
        }

        if (array_diff(array_keys($this->getSparseFieldsets()), array_keys($this->allowedSparseFieldsets)) !== []) {
            throw new IncorrectInclusionField($this->serverRequest);
        }

        foreach ($this->getSparseFieldsets() as $relation => $fieldset) {
            if (array_diff($fieldset, $this->allowedSparseFieldsets[$relation]) !== []) {
                throw new IncorrectInclusionField($this->serverRequest);
            }
        }
    }
}
