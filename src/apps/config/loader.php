<?php

$loader = new \Phalcon\Loader();

/**
  * Load library namespace
  */
$loader->registerNamespaces(array(
    'App\Library\Commands' => APP_PATH . '/library/commands',
    'App\Library\Orm' => APP_PATH . '/library/orm',
    'App\Library\Utils' => APP_PATH . '/library/utils',
    'Core\Library\Commands' => CORE_PATH . '/library/commands',
    'Core\Library\Repositories' => CORE_PATH . '/library/repositories',
    'Core\Modules\Author\Commands' => CORE_PATH . '/modules/author/commands',
    'Core\Modules\Author\Requests' => CORE_PATH . '/modules/author/requests',
    'Core\Modules\Book\Commands' => CORE_PATH . '/modules/book/commands',
    'Core\Modules\Book\Requests' => CORE_PATH . '/modules/book/requests',
));


$loader->register();
