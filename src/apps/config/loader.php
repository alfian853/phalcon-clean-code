<?php

$loader = new \Phalcon\Loader();

/**
  * Load library namespace
  */
$loader->registerNamespaces(array(
    'App\Library\Commands' => APP_PATH . '/library/commands',
));

$loader->register();
