<?php

declare(strict_types=1);

use Ecotone\Lite\EcotoneLite;
use Ecotone\Messaging\Config\ServiceConfiguration;
use HaydenPierce\ClassFinder\ClassFinder;
use Psr\Container\ContainerInterface;

return [
    'ecotone_flow_testing' => static fn(ContainerInterface $container) => EcotoneLite::bootstrapFlowTesting(
        classesToResolve: ClassFinder::getClassesInNamespace('App\Domain\Entity'),
        containerOrAvailableServices: $container,
        configuration: ServiceConfiguration::createWithDefaults()
            ->withNamespaces(["App\Domain\Entity"])
            ->withFailFast(false)
    ),
];