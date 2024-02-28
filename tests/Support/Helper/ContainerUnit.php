<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Application\Command\CommandInterface;
use App\Application\Query\QueryInterface;
use DI\ContainerBuilder;
use Ecotone\Lite\Test\FlowTestSupport;
use Psr\Container\ContainerInterface;

class ContainerUnit extends \Codeception\Module
{
    protected const string PATH_TO_CONFIG = __DIR__ . '/../../../config/';

    protected ContainerInterface $container;

    public function _initialize(): void
    {
        $this->container = (new ContainerBuilder())
            ->useAttributes(true)
            ->addDefinitions(self::PATH_TO_CONFIG . 'autowiring.php')
            ->addDefinitions(self::PATH_TO_CONFIG . 'database_test.php')
            ->addDefinitions(self::PATH_TO_CONFIG . 'ecotone_test.php')
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

    public function sendCommand(CommandInterface $command): FlowTestSupport
    {
        return $this->ecotone()->sendCommand($command);
    }

    public function sendQuery(QueryInterface $query): mixed
    {
        return $this->ecotone()->sendQuery($query);
    }
}
