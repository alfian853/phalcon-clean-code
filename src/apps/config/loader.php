<?php

$loader = new \Phalcon\Loader();

/**
  * Load library namespace
  */
$loader->registerNamespaces(array(
    'App\Library\Commands' => APP_PATH . '/library/commands',
    'App\Library\Orm' => APP_PATH . '/library/orm',
    'App\Library\Utils' => APP_PATH . '/library/utils',
    'Core\Library' => CORE_PATH . '/library',
    'Core\Library\Commands' => CORE_PATH . '/library/commands',
    'Core\Library\DataTables' => CORE_PATH . '/library/datatables',
    'Core\Library\Repositories' => CORE_PATH . '/library/repositories',
    'Core\Library\Requests' => CORE_PATH . '/library/requests',
    'Core\Modules\Inventory\Commands' => CORE_PATH . '/modules/inventory/commands',
    'Core\Modules\Inventory\Entities' => CORE_PATH . '/modules/inventory/entities',
    'Core\Modules\Inventory\Orm' => CORE_PATH . '/modules/inventory/orm',
    'Core\Modules\Inventory\Requests' => CORE_PATH . '/modules/inventory/requests',
    'Core\Modules\Inventory\Services' => CORE_PATH . '/modules/inventory/services',
    'Core\Modules\Inventory\Utils' => CORE_PATH . '/modules/inventory/utils',
));


$loader->register();
