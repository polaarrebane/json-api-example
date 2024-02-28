<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use App\Infrastructure\Database\Util\SchemaCompiler;
use Cycle\Database\Config;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\Schema;
use Cycle\ORM\ORM;

$dbConfig = new Config\DatabaseConfig([
    'default' => 'ishual_books',
    'databases' => [
        'ishual_books' => [
            'connection' => 'sqlite_test_file'
        ]
    ],
    'connections' => [
        'sqlite_test_file' => new Config\SQLiteDriverConfig(
            connection: new Config\SQLite\FileConnectionConfig(
                database: __DIR__ . '/../runtime/database.tests.sqlite'
            ),
            queryCache: false,
        ),
    ]
]);

return [
    DatabaseManager::class => static fn() => new DatabaseManager($dbConfig),

    ORM::class => static function (ContainerInterface $container) {
        $schema = ($container->get(SchemaCompiler::class))();

        return new ORM(
            new Factory($container->get(DatabaseManager::class)),
            new Schema($schema)
        );
    },

    EntityManager::class => static function (ContainerInterface $container) {
        return new EntityManager($container->get(ORM::class));
    },
];