<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Command;

use Cycle\Annotated\Embeddings;
use Cycle\Annotated\Entities;
use Cycle\Annotated\Locator\TokenizerEmbeddingLocator;
use Cycle\Annotated\Locator\TokenizerEntityLocator;
use Cycle\Annotated\MergeColumns;
use Cycle\Annotated\MergeIndexes;
use Cycle\Annotated\TableInheritance;
use Cycle\Migrations;
use Cycle\Database\DatabaseManager;
use Cycle\Migrations\Config\MigrationConfig;
use Cycle\Migrations\Migrator;
use Cycle\Schema\Compiler;
use Cycle\Schema\Generator\ForeignKeys;
use Cycle\Schema\Generator\GenerateModifiers;
use Cycle\Schema\Generator\GenerateRelations;
use Cycle\Schema\Generator\GenerateTypecast;
use Cycle\Schema\Generator\Migrations\GenerateMigrations;
use Cycle\Schema\Generator\RenderModifiers;
use Cycle\Schema\Generator\RenderRelations;
use Cycle\Schema\Generator\RenderTables;
use Cycle\Schema\Generator\ResetTables;
use Cycle\Schema\Generator\ValidateEntities;
use Cycle\Schema\Registry;
use DI\Attribute\Inject;
use Spiral\Tokenizer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'migration:compile',
    description: 'Generate a set of migration files during schema compilation.',
)]
class MigrationCompile extends Command
{
    #[Inject]
    protected Migrator $migrator;

    #[Inject]
    protected DatabaseManager $dbal;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $outputStyle = new OutputFormatterStyle('red');
        $output->getFormatter()->setStyle('fire', $outputStyle);

        foreach ($this->migrator->getMigrations() as $migration) {
            if ($migration->getState()->getStatus() === 0) {
                $output->writeln("<fire>There are migrations that have not been applied to the database. Unable to generate migrations.</fire>");

                return Command::FAILURE;
            }
        }

        $classLocator = (new Tokenizer\Tokenizer(new Tokenizer\Config\TokenizerConfig([
            'directories' => [__DIR__ . '/../../Database/Entity'],
        ])))->classLocator();

        $embeddingClassLocator = new TokenizerEmbeddingLocator($classLocator);
        $entitiesClassLocator = new TokenizerEntityLocator($classLocator);

        $schema = (new Compiler())->compile(new Registry($this->dbal), [
            new ResetTables(),                          // re-declared table schemas (remove columns)
            new Embeddings($embeddingClassLocator),     // register embeddable entities
            new Entities($entitiesClassLocator),        // register annotated entities
            new TableInheritance(),                     // register STI/JTI
            new MergeColumns(),                         // register columns from attributes
            new GenerateRelations(),                    // generate entity relations
            new GenerateModifiers(),                    // generate changes from schema modifiers
            new ValidateEntities(),                     // make sure all entity schemas are correct
            new RenderTables(),                         // declare table schemas
            new RenderRelations(),                      // declare relation keys and indexes
            new RenderModifiers(),                      // render all schema modifiers
            new ForeignKeys(),                          // Define foreign key constraints
            new MergeIndexes(),                         // register indexes from attributes
            new GenerateMigrations(
                $this->migrator->getRepository(),
                $this->migrator->getConfig()
            ),                                          // generate migrations
            new GenerateTypecast(),                     // typecast non string columns
        ]);

        return Command::SUCCESS;
    }
}
