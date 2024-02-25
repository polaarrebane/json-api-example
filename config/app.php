<?php

declare(strict_types=1);

use League\Config\Configuration;
use Nette\Schema\Expect;

return [
    Configuration::class => static function () {
        $configStructure = [
            'app' => Expect::structure([
                'url' => Expect::string()->default('localhost'),
            ])
        ];

        $config = new Configuration($configStructure);
        $config->set('app.url', $_ENV['APP_URL']);

        return $config;
    }
];

