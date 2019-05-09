<?php
namespace App\BookLibrary;
use App\BookLibrary\Commands\AddAuthorCommand;
use App\BookLibrary\Commands\AddBookCommand;
use App\BookLibrary\Commands\GetAuthorCommand;
use App\BookLibrary\Commands\GetBookCommand;
use App\BookLibrary\Repositories\AuthorRepository;
use App\BookLibrary\Repositories\BookRepository;
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
            'App\BookLibrary\Models' => __DIR__ . '/models',
            'App\BookLibrary\Repositories' => __DIR__ . '/repository',
            'App\BookLibrary\Request' => __DIR__ . '/request',
        ]);
        $loader->register();

        $this->registerCommands($di);
    }

    private function registerCommands(DiInterface $di){
        $commandContainer = $di->get('commands');
        $bookRepository = new BookRepository();
        $authorRepository = new AuthorRepository();

        $commandContainer->add(new AddAuthorCommand($authorRepository));
        $commandContainer->add(new AddBookCommand($bookRepository));
        $commandContainer->add(new GetAuthorCommand($authorRepository));
        $commandContainer->add(new GetBookCommand($bookRepository));

        //autoload command jika tidak pakai contructor dependency injection
//        $files = array_diff(scandir(__DIR__ . "/commands/"), array('..', '.'));
//        foreach ($files as $file) {
//            if(substr($file,-11) == 'CommandInterface.php'){
//                $commandContainer->add(
//                    'App\\BookLibrary\\Commands\\' . substr($file,0,strlen($file)-4)
//                );
//            }
//        }
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