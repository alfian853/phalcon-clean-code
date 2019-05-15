<?php
namespace App\Inventory\Controllers\Web;

use Core\Library\Commands\CommandContainer;
use Core\Modules\Book\Commands\AddBookCommand;
use Core\Modules\Book\Commands\GetBookCommand;
use Core\Modules\Book\Requests\AddBookRequest;
use Phalcon\Mvc\Controller;

/**
 * Class InventoryController
 * @property CommandContainer commands injected into DI
 */
class InventoryController extends Controller
{

    public function indexAction() {
        return $this->view->pick('table');
    }

}