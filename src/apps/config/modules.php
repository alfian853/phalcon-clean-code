<?php

return array(

    'inventory' => [
        'namespace' => 'App\Inventory',
        'webControllerNamespace' => 'App\Inventory\Controllers\Web',
        'apiControllerNamespace' => 'App\Inventory\Controllers\Api',
        'className' => 'App\Inventory\Module',
        'path' => APP_PATH . '/modules/inventory/Module.php',
        'defaultRouting' => true,
        'defaultController' => 'Inventory',
        'defaultAction' => 'index'
    ],
);