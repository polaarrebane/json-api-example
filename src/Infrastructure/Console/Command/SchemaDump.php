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
use Cycle\Database\DatabaseManager;
use Cycle\Schema\Compiler;
use Cycle\Schema\Generator\ForeignKeys;
use Cycle\Schema\Generator\GenerateModifiers;
use Cycle\Schema\Generator\GenerateRelations;
use Cycle\Schema\Generator\GenerateTypecast;
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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'schema:dump',
    description: '',
)]
class SchemaDump extends Command
{
    protected const string PATH = __DIR__ . '/../../../../database/schema.json';

    #[Inject]
    protected DatabaseManager $dbal;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
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
            new GenerateTypecast(),                     // typecast non string columns
        ]);

        file_put_contents(self::PATH, json_encode($schema, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
