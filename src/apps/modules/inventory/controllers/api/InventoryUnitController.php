<?php
namespace App\Inventory\Controllers\Api;

use Core\Library\Commands\CommandContainer;
use Core\Library\Requests\DataTableRequest;
use Core\Modules\Inventory\Commands\GetInventoryTableCommand;
use Core\Modules\Inventory\Commands\GetInventoryUnitTableCommand;
use Core\Modules\Inventory\Requests\InventoryRequest;
use Core\Modules\Inventory\Services\InventoryService;
use Phalcon\Mvc\Controller;
/**
 * Class InventoryUnitController
 * @property CommandContainer commands injected into DI
 * @property InventoryService inventoryService injected into DI
 */
class InventoryUnitController extends Controller
{

    private function sendResponse($res){
        $response = $this->response;
        $response->setContentType('application/json');
        $response->setContent(json_encode($res));
        $response->send();
    }

    public function dataAction() {
        $request = $this->request->getQuery();

        $dataRequest = new DataTableRequest();
        foreach ($request['columns'] as $query){
            if($query['name'] == 'action')continue;
            $dataRequest->addColumn($query['name'],$query['search']['value'],$query['searchable']);
        }
        $dataRequest->setOrderBy($request['columns'][$request['order'][0]['column']]['name']);
        $dataRequest->setOrderDir( $request['order'][0]['dir']);
        $dataRequest->setStart($request['start']);
        $dataRequest->setLength($request['length']);
        $dataRequest->setDraw($request['draw']);

        $this->sendResponse(
            $this->commands->get(GetInventoryUnitTableCommand::class)->execute($dataRequest)
        );
    }

    public function detailAction(){
        $request = $this->request->getQuery();
        $inventory = $this->inventoryService->getInventory($request['id']);
        $this->sendResponse([
            'id' => $inventory->getId(),
            'name' => $inventory->getName(),
            'price' => $inventory->getPrice(),
            'quantity' => $inventory->getQuantity(),
            'type' => $inventory->getType(),
            'category_id' => $inventory->getCategory()->getId(),
            'description' => $inventory->getDescription()
        ]);
    }


}