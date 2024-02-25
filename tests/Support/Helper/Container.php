<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use DI\ContainerBuilder;
use Ecotone\Lite\Test\FlowTestSupport;
use Psr\Container\ContainerInterface;

class Container extends \Codeception\Module
{
    protected const string PATH_TO_CONFIG = __DIR__ . '/../../../config/';

    protected ContainerInterface $container;

    public function _initialize(): void
    {
        $this->container = (new ContainerBuilder())
            ->addDefinitions(self::PATH_TO_CONFIG . 'test.php')
            ->build();
    }

    public function container(): \DI\Container
    {
        return $this->container;
    }

    public function ecotone(): FlowTestSupport
    {
        return $this->container->get('ecotone_flow_testing');
    }
}
