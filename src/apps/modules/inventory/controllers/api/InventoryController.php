<?php
namespace App\Inventory\Controllers\Api;

use Core\Library\Commands\CommandContainer;
use Core\Modules\Inventory\Commands\GetInventoryTableCommand;
use Phalcon\Mvc\Controller;
/**
 * Class InventoryController
 * @property CommandContainer commands injected into DI
 */
class InventoryController extends Controller
{

    private function sendResponse($res){
        $response = $this->response;
        $response->setContentType('application/json');
        $response->setContent(json_encode($res));
        $response->send();
    }


    public function dataAction() {
        $queries = $this->request->getQuery();
        $this->sendResponse(
            $this->commands->get(GetInventoryTableCommand::class)->execute($queries)
        );
    }



}