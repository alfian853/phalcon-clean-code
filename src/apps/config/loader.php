<?php

$loader = new \Phalcon\Loader();

/**
  * Load library namespace
  */
$loader->registerNamespaces(array(
    'App\Library\Commands' => APP_PATH . '/library/commands',
    'App\Library\Orm' => APP_PATH . '/library/orm',
    'App\Library\Utils' => APP_PATH . '/library/utils',
));

$loader->register();
