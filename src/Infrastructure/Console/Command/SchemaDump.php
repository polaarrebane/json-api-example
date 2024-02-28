<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Command;

use App\Infrastructure\Database\Util\SchemaCompiler;
use DI\Attribute\Inject;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'schema:dump',
    description: "Export the schema of a database to file 'database/schema.json'",
)]
class SchemaDump extends Command
{
    protected const string PATH = __DIR__ . '/../../../../database/schema.json';

    #[Inject]
    protected SchemaCompiler $schemaCompiler;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        file_put_contents(self::PATH, json_encode(($this->schemaCompiler)(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
