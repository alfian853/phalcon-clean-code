<?php
namespace App\BookLibrary;
use App\BookLibrary\Commands\AddBookCommand;
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
            'App\BookLibrary\Controllers\Web' => __DIR__ . '/controllers/web',
            'App\BookLibrary\Controllers\Api' => __DIR__ . '/controllers/api',
            'App\BookLibrary\Controllers\Common' => __DIR__ . '/controllers/common',
            'App\BookLibrary\Commands' => __DIR__ . '/commands',
        ]);
        $loader->register();

        $this->registerCommands($di);
    }

    private function registerCommands(DiInterface $di){
        $commandContainer = $di->get('commands');
        $commandContainer->add(AddBookCommand::class);
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