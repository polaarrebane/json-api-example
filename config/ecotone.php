<?php

declare(strict_types=1);

use Ecotone\Lite\EcotoneLite;
use Ecotone\Lite\Test\Configuration\InMemoryRepositoryBuilder;
use Ecotone\Messaging\Config\ServiceConfiguration;
use Psr\Container\ContainerInterface;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;

return [
    'ecotone' => static fn(ContainerInterface $container) => EcotoneLite::bootstrap(
        containerOrAvailableServices: $container,
        configuration: ServiceConfiguration::createWithDefaults()
            ->withNamespaces(["App"])
            ->withFailFast(false)
            ->withExtensionObjects([InMemoryRepositoryBuilder::createForAllStateStoredAggregates()]),
    ),

    CommandBus::class =>
        static fn(ContainerInterface $container) => $container->get('ecotone')->getCommandBus(),

    QueryBus::class =>
        static fn(ContainerInterface $container) => $container->get('ecotone')->getQueryBus(),
];