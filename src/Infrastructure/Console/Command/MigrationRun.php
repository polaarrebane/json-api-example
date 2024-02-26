<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Command;

use Cycle\Migrations\Migrator;
use DI\Attribute\Inject;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'migration:run',
    description: 'Run migrations',
)]
class MigrationRun extends Command
{
    #[Inject]
    protected Migrator $migrator;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        while ($this->migrator->run() !== null) {
        }

        return Command::SUCCESS;
    }
}
