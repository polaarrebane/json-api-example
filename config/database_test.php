<?php

declare(strict_types=1);

use Cycle\ORM\FactoryInterface;
use Cycle\ORM\SchemaInterface;
use League\Config\Configuration;
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

return [
    DatabaseManager::class => static function (ContainerInterface $container) {
        $config = $container->get(Configuration::class);
        $dbConfig = new Config\DatabaseConfig([
            'default' => 'ishual_books',
            'databases' => [
                'ishual_books' => [
                    'connection' => 'postgres_test'
                ]
            ],
            'connections' => [
                'postgres_test' => new Config\PostgresDriverConfig(
                    connection: new Config\Postgres\TcpConnectionConfig(
                        database: $config->get('db_test.database'),
                        host: $config->get('db_test.host'),
                        port: $config->get('db_test.port'),
                        user: $config->get('db_test.user'),
                        password: $config->get('db_test.password'),
                    ),
                    schema: 'public',
                    queryCache: false,
                ),
            ]
        ]);

        $logger = new Logger('test_db_logger');

        $fileHandler = new StreamHandler(__DIR__ . '/../logs/test_db.log', Level::Debug);
        $fileHandler->setFormatter(new LineFormatter());
        $logger->pushHandler($fileHandler);

        $dbal = new DatabaseManager($dbConfig);
        $dbal->setLogger($logger);

        return $dbal;
    },

    SchemaInterface::class => static function (ContainerInterface $container) {
        $schema = ($container->get(SchemaCompiler::class))();

        return new Schema($schema);
    },

    FactoryInterface::class => static fn(ContainerInterface $container) => new Factory($container->get(DatabaseManager::class)),
];