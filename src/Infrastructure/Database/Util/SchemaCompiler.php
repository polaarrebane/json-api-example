<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Util;

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

class SchemaCompiler
{
    #[Inject]
    protected DatabaseManager $dbal;

    protected const string PATH_TO_ENTITIES = __DIR__ . '/../../Database/Entity';

    /**
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        $classLocator = (new Tokenizer\Tokenizer(new Tokenizer\Config\TokenizerConfig([
            'directories' => [self::PATH_TO_ENTITIES],
        ])))->classLocator();

        $embeddingClassLocator = new TokenizerEmbeddingLocator($classLocator);
        $entitiesClassLocator = new TokenizerEntityLocator($classLocator);

        return (new Compiler())->compile(new Registry($this->dbal), [
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
    }
}
