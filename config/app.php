<?php

declare(strict_types=1);

use League\Config\Configuration;
use Nette\Schema\Expect;

return [
    Configuration::class => static function () {
        $configStructure = [
            'app' => Expect::structure([
                'url' => Expect::string(),
                'image_hosting_service' => Expect::string(),
            ]),
            'db' => Expect::structure([
                'host' => Expect::string(),
                'port' => Expect::int(),
                'database' => Expect::string(),
                'user' => Expect::string(),
                'password' => Expect::string(),
            ]),
            'db_test' => Expect::structure([
                'host' => Expect::string(),
                'port' => Expect::int(),
                'database' => Expect::string(),
                'user' => Expect::string(),
                'password' => Expect::string(),
            ]),
        ];

        $config = new Configuration($configStructure);

        $config->set('app.url', $_ENV['APP_URL']);
        $config->set('app.image_hosting_service', $_ENV['APP_IMAGE_HOSTING_SERVICE']);

        $config->set('db.host', $_ENV['POSTGRES_DB_HOST']);
        $config->set('db.port', (int)$_ENV['POSTGRES_DB_PORT']);
        $config->set('db.database', $_ENV['POSTGRES_DB_DBNAME']);
        $config->set('db.user', $_ENV['POSTGRES_DB_USER']);
        $config->set('db.password', $_ENV['POSTGRES_DB_PASSWORD']);

        $config->set('db_test.host', $_ENV['POSTGRES_DB_HOST_TEST']);
        $config->set('db_test.port', (int)$_ENV['POSTGRES_DB_PORT_TEST']);
        $config->set('db_test.database', $_ENV['POSTGRES_DB_DBNAME_TEST']);
        $config->set('db_test.user', $_ENV['POSTGRES_DB_USER_TEST']);
        $config->set('db_test.password', $_ENV['POSTGRES_DB_PASSWORD_TEST']);

        return $config;
    }
];

