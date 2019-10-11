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
//            'adapter' => 'Phalcon\Db\Adapter\Pdo\Postgresql',
            'host' => getenv("DB_HOST"),
            'port' => getenv("DB_PORT"),
            'username' => getenv("DB_USERNAME"),
            'password' => getenv("DB_PASS"),
            'dbname' => getenv("DB_NAME")
        ],   

        'url' => [
            'baseUrl' => 'http://192.168.16.73:8008/',
        ],
        
        'application' => [
            'libraryDir' => APP_PATH . "/lib/",
            'cacheDir' => APP_PATH . "/cache/",
        ],

        'version' => '0.1',
    ]
);
    
