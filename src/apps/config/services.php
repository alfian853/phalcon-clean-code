<?php

use App\Inventory\Repositories\InventoryRepository;
use App\Oauth\Repository\AuthCodeRepository;
use App\Oauth\Repository\RefreshTokenRepository;
use Core\Library\Commands\CommandContainer;
use Core\Modules\Inventory\Commands\GetInventoryTableCommand;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use Phalcon\Http\Response;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Security;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use App\Oauth\Repository\AccessTokenRepository;
use App\Oauth\Repository\ScopeRepository;
use App\Oauth\Repository\UserRepository;
use App\Oauth\Repository\ClientRepository;
use League\OAuth2\Server\AuthorizationServer;



//$di->setShared('db', function () use ($config) {
//    $connection = new DbAdapter([
//        'host' => $config->database->host,
//        'username' => $config->database->username,
//        'password' => $config->database->password,
//        'dbname' => $config->database->dbname,
//        'port' => $config->database->port
//    ]);
//
//    if ($config->debug) {
//        $eventsManager = new Phalcon\Events\Manager();
//        $logger = new Phalcon\Logger\Adapter\File($config->application->logsDir . "sql_debug.log");
//
//        $eventsManager->attach('db', function ($event, $connection) use ($logger) {
//            if ($event->getType() == 'beforeQuery') {
//                /** @var DbAdapter $connection */
//                $logger->log($connection->getSQLStatement(), Logger::DEBUG);
//            }
//        });
//
//        $connection->setEventsManager($eventsManager);
//    }
//
//    return $connection;
//});


$di->setShared('modelsManager', function () {
    return new Phalcon\Mvc\Model\Manager();
});


$di['config'] = function() use ($config) {
	return $config;
};

$di['session'] = function() {
    $session = new Session();
	$session->start();

	return $session;
};

$di['dispatcher'] = function() use ($di, $defaultModule) {

    $eventsManager = $di->getShared('eventsManager');
    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};

$di['url'] = function() use ($config, $di) {
	$url = new \Phalcon\Mvc\Url();

    $url->setBaseUri($config->url['baseUrl']);

	return $url;
};

$di['voltService'] = function($view, $di) use ($config) {
    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
    if (!is_dir($config->application->cacheDir)) {
        mkdir($config->application->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT' ? true : false;

    $volt->setOptions(array(
        "compiledPath" => $config->application->cacheDir,
        "compiledExtension" => ".compiled",
        "compileAlways" => $compileAlways
    ));
    return $volt;
};

$di->set(
    'security',
    function () {
        $security = new Security();
        $security->setWorkFactor(12);

        return $security;
    },
    true
);

$di->set(
    'flash',
    function () {
        $flash = new FlashDirect(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );

        return $flash;
    }
);

$di->set(
    'flashSession',
    function () {
        $flash = new FlashSession(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );

        $flash->setAutoescape(false);
        
        return $flash;
    }
);

$di['response'] = function () {
    return new Response();
};

$di->setShared('db', function() use ($di) {
    $config = require APP_PATH.'/config/config.php';

    $type = $config->database->adapter;
    $creds = array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    );

    if ($type == 'Phalcon\Db\Adapter\Pdo\Mysql') {
        $connection =  new \Phalcon\Db\Adapter\Pdo\Mysql($creds);
    }
    else if($type == 'Phalcon\Db\Adapter\Pdo\Postgresql'){
        $connection =  new \Phalcon\Db\Adapter\Pdo\Postgresql($creds);
    }
    else {
        throw new Exception('Bad Database Adapter');
    }

    return $connection;
});

$di->setShared('oauth2Server',function () use ($config){

    $clientRepository = new ClientRepository();
    $scopeRepository = new ScopeRepository();
    $accessTokenRepository = new AccessTokenRepository();
    $userRepository = new UserRepository();
    $refreshTokenRepository = new RefreshTokenRepository();
    $authCodeRepository = new AuthCodeRepository();

    $encryptionKey = "/FnEkTX3bA2u+R4u9PG0vTy3IMnhci9gLYd9pzarZq0=";

    $server = new AuthorizationServer(
        $clientRepository,
        $accessTokenRepository,
        $scopeRepository,
        APP_PATH.'/private.key',
        $encryptionKey
    );

    $passwordGrant = new \League\OAuth2\Server\Grant\PasswordGrant($userRepository, $refreshTokenRepository);
    $passwordGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);

    $authCodeGrant = new AuthCodeGrant(
        $authCodeRepository,
        $refreshTokenRepository,
        $config->oauth->auth_code_lifespan
    );

    $refreshTokenGrant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);
    $refreshTokenGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);

    $server->enableGrantType($refreshTokenGrant, $config->oauth->access_token_lifespan);
    $authCodeGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);

    $server->enableGrantType($authCodeGrant, $config->oauth->access_token_lifespan);

    $server->enableGrantType($passwordGrant, $config->oauth->access_token_lifespan);

    $server->enableGrantType(new ClientCredentialsGrant(), $config->oauth->access_token_lifespan);

    $server->enableGrantType(
        new \League\OAuth2\Server\Grant\ImplicitGrant($config->oauth->access_token_lifespan),
        $config->oauth->access_token_lifespan
    );

    return $server;
});


$di->setShared('commands', function (){
    $container = new CommandContainer();
    $container->add(new GetInventoryTableCommand(new InventoryRepository()));
    return $container;
});