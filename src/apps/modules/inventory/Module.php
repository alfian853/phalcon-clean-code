<?php
namespace App\Inventory;
use App\Inventory\Repositories\InventoryRepository;
use App\Library\Utils\AppItemDetailPdfGenerator;
use App\Library\Utils\ViewWrapper;
use Core\Modules\Inventory\Commands\SendInventoryPdfCommand;
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
            'App\Inventory\Controllers\Web' => __DIR__ . '/controllers/web',
            'App\Inventory\Controllers\Api' => __DIR__ . '/controllers/api',
            'App\Inventory\Controllers\Common' => __DIR__ . '/controllers/common',
            'App\Inventory\Models' => __DIR__ . '/models',
            'App\Inventory\Repositories' => __DIR__ . '/repository',
            'App\Inventory\Mappers' => __DIR__ . '/mappers',
            'App\Inventory\Traits' => __DIR__ . '/traits'
        ]);
        $loader->register();
    }

    private function registerCommands(DiInterface $di){
        //autoload commands jika tidak pakai contructor dependency injection
//        $files = array_diff(scandir(__DIR__ . "/commands/"), array('..', '.'));
//        foreach ($files as $file) {
//            if(substr($file,-11) == 'CommandInterface.php'){
//                $commandContainer->add(
//                    'App\\Inventory\\Commands\\' . substr($file,0,strlen($file)-4)
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
        $di['simpleView'] = function () {
            $view = new View\Simple();
            $view->setViewsDir(__DIR__ . '/views/');
            $view->registerEngines(
                [
                    ".volt" => "voltService",
                ]
            );
            return $view;
        };

        $di['itemPdfGenerator'] = function () use($di) {
            $pdfGenerator = new AppItemDetailPdfGenerator($di->get('simpleView'));
            $pdfGenerator->setViewPath("inventory_pdf_template");
            return $pdfGenerator;
        };

        $di->get('commands')->add(
            new SendInventoryPdfCommand($di->get("itemPdfGenerator"),$di->get("inventoryUnitRepository"))
        );


    }
}