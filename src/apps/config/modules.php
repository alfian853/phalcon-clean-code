<?php

return array(
 
    'oauth' => [
        'namespace' => 'App\Oauth',
        'webControllerNamespace' => 'App\Oauth\Controllers\Web',
        'apiControllerNamespace' => 'App\Oauth\Controllers\Api',
        'className' => 'App\Oauth\Module',
        'path' => APP_PATH . '/modules/oauth/Module.php',
        'defaultRouting' => true,
        'defaultController' => '',
        'defaultAction' => 'index'
    ],
    'book_library' => [
        'namespace' => 'App\BookLibrary',
        'webControllerNamespace' => 'App\BookLibrary\Controllers\Web',
        'apiControllerNamespace' => 'App\BookLibrary\Controllers\Api',
        'className' => 'App\BookLibrary\Module',
        'path' => APP_PATH . '/modules/book_library/Module.php',
        'defaultRouting' => true,
        'defaultController' => 'Book',
        'defaultAction' => 'index'
    ],
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