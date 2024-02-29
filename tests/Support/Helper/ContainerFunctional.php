<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Application\Command\CommandInterface;
use App\Application\Query\QueryInterface;
use App\Domain\Dto\DtoInterface;
use DI\ContainerBuilder;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;
use Psr\Container\ContainerInterface;

class ContainerFunctional extends \Codeception\Module
{
    protected const string PATH_TO_CONFIG = __DIR__ . '/../../../config/';

    protected ContainerInterface $container;

    public function _initialize(): void
    {
        $this->container = (new ContainerBuilder())
            ->useAttributes(true)
            ->addDefinitions(self::PATH_TO_CONFIG . 'autowiring.php')
            ->addDefinitions(self::PATH_TO_CONFIG . 'database_test.php')
            ->addDefinitions(self::PATH_TO_CONFIG . 'ecotone.php')
            ->build();
    }

    public function container(): \DI\Container
    {
        return $this->container;
    }

    public function sendCommand(CommandInterface $command): mixed
    {
        /** @var CommandBus $commandBus */
        $commandBus = $this->container->get(CommandBus::class);

        return $commandBus->send($command);
    }

    public function sendQuery(QueryInterface $query): DtoInterface
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->container->get(QueryBus::class);

        return $queryBus->send($query);
    }
}
