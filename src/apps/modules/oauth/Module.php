<?php
namespace App\Oauth;
use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

class Module implements ModuleDefinitionInterface
{
    /**
     * Register a specific autoloader for the module
     * @param DiInterface|null $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces([
            'App\Oauth\Controllers\Web' => __DIR__ . '/controllers/web',
            'App\Oauth\Controllers\Api' => __DIR__ . '/controllers/api',
            'App\Oauth\Controllers\Common' => __DIR__ . '/controllers/common',
            'App\Oauth\Library' => __DIR__ . '/library',
            'App\Oauth\CInterface' => __DIR__ . '/interfaces',
            'App\Oauth\Repository' => __DIR__ . '/repository',
            'App\Oauth\Models' => __DIR__ . '/models'
        ]);
        $loader->register();
    }

    /**
     * Register specific services for the module
     * @param DiInterface|null $di
     */
    public function registerServices(DiInterface $di = null)
    {
        // Registering the view component
        $di['view'] = function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            $view->registerEngines(
                [
                    ".volt" => "voltService",
                ]
            );
            return $view;
        };
    }
}