<?php

use Phalcon\Config;

try {
    $oneMonthInterval = new \DateInterval('P1M');
    $oneHourInterval = new \DateInterval('PT1H');
    $tenMinutesInterval = new \DateInterval('PT10M');
} catch (Exception $e) {
}

return new Config(
    [
        'mode' => 'DEVELOPMENT', //DEVELOPMENT, PRODUCTION, DEMO

        'database' => [
            'adapter' => 'Phalcon\Db\Adapter\Pdo\Mysql',
            'host' => getenv("DB_HOST"),
            'port' => getenv("DB_PORT"),
            'username' => getenv("DB_USERNAME"),
            'password' => getenv("DB_PASS"),
            'dbname' => getenv("DB_NAME")
        ],   

        'url' => [
            'baseUrl' => 'http://oidc.local/',
        ],
        
        'application' => [
            'libraryDir' => APP_PATH . "/lib/",
            'cacheDir' => APP_PATH . "/cache/",
        ],

        'oauth' => [
            'refresh_token_lifespan' => $oneMonthInterval,
            'access_token_lifespan' => $oneHourInterval,
            'auth_code_lifespan' => $tenMinutesInterval,
            'always_include_client_scopes' => true,
        ],

        'version' => '0.1',
    ]
);
    