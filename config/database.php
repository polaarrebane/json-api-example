<?php

declare(strict_types=1);

use Cycle\Database;
use Cycle\Database\Config;
use Cycle\Database\DatabaseManager;
use Cycle\Migrations\Config\MigrationConfig;
use Cycle\Migrations\FileRepository;
use Cycle\Migrations\Migrator;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\Schema;
use Cycle\ORM\ORM;
use Psr\Container\ContainerInterface;

// https://cycle-orm.dev/docs/database-connect/current/en

$dbConfig = new Config\DatabaseConfig([
    'default' => 'ishual_books',
    'databases' => [
        'ishual_books' => [
            'connection' => 'sqlite_file'
        ]
    ],
    'connections' => [
        'sqlite_file' => new Config\SQLiteDriverConfig(
            connection: new Config\SQLite\FileConnectionConfig(
                database: __DIR__ . '/../runtime/database.sqlite'
            ),
            queryCache: true,
        ),
    ]
]);

return [
    DatabaseManager::class => static fn() => new DatabaseManager($dbConfig),

    ORM::class => static function (ContainerInterface $container) {
        $schemaDump = file_get_contents(__DIR__ . '/../database/schema.json');

        return new ORM(
            new Factory($container->get(DatabaseManager::class)),
            new Schema(json_decode($schemaDump, true, 512, JSON_THROW_ON_ERROR))
        );
    },

    EntityManager::class => static function (ContainerInterface $container) {
        return new EntityManager($container->get(ORM::class));
    },

    Migrator::class =>  static function (ContainerInterface $container) {
        $config = new MigrationConfig([
            'directory' => __DIR__ . '/../database/migrations/',    // where to store migrations
            'table'     => 'migrations',                   // database table to store migration status
            'safe'      => true                            // When set to true no confirmation will be requested on migration run.
        ]);

        $migrator = new Migrator($config, $container->get(DatabaseManager::class), new FileRepository($config));
        $migrator->configure();

        return $migrator;
    },
];