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
            ])
        ];

        $config = new Configuration($configStructure);
        $config->set('app.url', $_ENV['APP_URL']);
        $config->set('app.image_hosting_service', $_ENV['APP_IMAGE_HOSTING_SERVICE']);

        return $config;
    }
];
