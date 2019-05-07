<?php
namespace App\BookLibrary\Controllers\Api;

use App\BookLibrary\Commands\AddBookCommand;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class BookController
 * @property \App\Library\Commands\Container commands injected into DI
 * @package App\Controllers
 */

class BookController extends Controller
{
    
    public function indexAction() {
        $request = new Request();
        $this->commands->get(AddBookCommand::class)->execute($request);
    }

}