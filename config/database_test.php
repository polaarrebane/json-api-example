<?php

declare(strict_types=1);

use Cycle\ORM\FactoryInterface;
use Cycle\ORM\SchemaInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use App\Infrastructure\Database\Util\SchemaCompiler;
use Cycle\Database\Config;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\Factory;
use Cycle\ORM\Schema;

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
                database: __DIR__ . '/../runtime/database.tests.sqlite',
            ),
            queryCache: false,
        ),
    ]
]);

return [
    DatabaseManager::class => static function () use ($dbConfig) {
        $logger = new Logger('test_db_logger');

        $fileHandler = new StreamHandler(__DIR__ . '/../logs/test_db.log', Level::Debug);
        $fileHandler->setFormatter(new LineFormatter());
        $logger->pushHandler($fileHandler);

        $dbal = new DatabaseManager($dbConfig);
        // $dbal->setLogger($logger);

        return $dbal;
    },

    SchemaInterface::class => static function (ContainerInterface $container) {
        $schema = ($container->get(SchemaCompiler::class))();

        return new Schema($schema);
    },


    FactoryInterface::class => static fn(ContainerInterface $container) => new Factory($container->get(DatabaseManager::class)),
];