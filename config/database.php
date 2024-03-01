<?php

declare(strict_types=1);

use App\Infrastructure\Database\Util\SchemaCompiler;
use Cycle\Database\Config;
use Cycle\Database\DatabaseManager;
use Cycle\Migrations\Config\MigrationConfig;
use Cycle\Migrations\FileRepository;
use Cycle\Migrations\Migrator;
use Cycle\ORM\Factory;
use Cycle\ORM\FactoryInterface;
use Cycle\ORM\Schema;
use Cycle\ORM\SchemaInterface;
use League\Config\Configuration;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

// https://cycle-orm.dev/docs/database-connect/current/en

return [
    DatabaseManager::class => static function (ContainerInterface $container) {
        $config = $container->get(Configuration::class);
        $dbConfig = new Config\DatabaseConfig([
            'default' => 'ishual_books',
            'databases' => [
                'ishual_books' => [
                    'connection' => 'postgres'
                ]
            ],
            'connections' => [
                'postgres' => new Config\PostgresDriverConfig(
                    connection: new Config\Postgres\TcpConnectionConfig(
                        database: $config->get('db.database'),
                        host: $config->get('db.host'),
                        port: $config->get('db.port'),
                        user: $config->get('db.user'),
                        password: $config->get('db.password'),
                    ),
                    schema: 'public',
                    queryCache: false,
                ),
            ]
        ]);

        $logger = new Logger('db_logger');

        $fileHandler = new StreamHandler(__DIR__ . '/../logs/db.log', Level::Debug);
        $fileHandler->setFormatter(new LineFormatter());
        $logger->pushHandler($fileHandler);

        $dbal = new DatabaseManager($dbConfig);
        // $dbal->setLogger($logger);

        return $dbal;
    },

    SchemaInterface::class => static function (ContainerInterface $container) {
        $pathToDump = __DIR__ . '/../database/schema.json';
        $schema = file_exists($pathToDump)
            ? json_decode(file_get_contents($pathToDump), true, 512, JSON_THROW_ON_ERROR)
            : ($container->get(SchemaCompiler::class))();

        return new Schema($schema);
    },

    FactoryInterface::class => static fn(ContainerInterface $container) => new Factory($container->get(DatabaseManager::class)),

    Migrator::class =>  static function (ContainerInterface $container) {
        $config = new MigrationConfig([
            'directory' => __DIR__ . '/../database/migrations/',    // where to store migrations
            'table'     => 'migrations',                            // database table to store migration status
            'safe'      => true                                     // When set to true no confirmation will be requested on migration run.
        ]);

        $migrator = new Migrator($config, $container->get(DatabaseManager::class), new FileRepository($config));
        $migrator->configure();

        return $migrator;
    },
];