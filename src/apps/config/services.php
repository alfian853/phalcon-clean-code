<?php

use App\Inventory\Repositories\CategoryRepository;
use App\Inventory\Repositories\InventoryRepository;
use Core\Library\Commands\CommandContainer;
use Core\Modules\Inventory\Commands\GetInventoryTableCommand;
use Core\Modules\Inventory\Commands\SearchCategoriesCommand;
use Core\Modules\Inventory\Services\InventoryService;
use Phalcon\Http\Response;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Security;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;


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


//$di->setShared('inventoryRepository',function()use ($inventoryRepository){
//    return $inventoryRepository;
//});

$di->setShared('commands', function(){
    $inventoryRepository = new InventoryRepository();
    $categoryRepository = new CategoryRepository();
    $container = new CommandContainer();
    $container->add(new GetInventoryTableCommand($inventoryRepository));
    $container->add(new SearchCategoriesCommand($categoryRepository));
    return $container;
});

$di->setshared('inventoryService',function() {
    $inventoryRepository = new InventoryRepository();
    $categoryRepository = new CategoryRepository();
    return new InventoryService($inventoryRepository, $categoryRepository);
});