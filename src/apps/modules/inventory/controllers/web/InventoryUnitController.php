<?php
namespace App\Inventory\Controllers\Web;

use Core\Library\Commands\CommandContainer;
use Core\Modules\Inventory\Requests\InventoryRequest;
use Core\Modules\Inventory\Requests\InventoryUnitRequest;
use Core\Modules\Inventory\Services\InventoryService;
use Core\Modules\Inventory\Services\InventoryUnitService;
use Phalcon\Mvc\Controller;

/**
 * Class InventoryUnitController
 * @property CommandContainer commands injected into DI
 * @property InventoryService inventoryService injected into DI
 * @property InventoryUnitService inventoryUnitService
 */
class InventoryUnitController extends Controller
{

    public function indexAction() {
        return $this->view->pick('inventory_unit_table');
    }

    public function createAction() {
        $request = $this->request->getPost();
        $createRequest = new InventoryUnitRequest();
        $createRequest->setInventoryId($request['inventory_id']);
        $createRequest->setWarehouseId($request['warehouse_id']);
        $createRequest->setRack($request['rack']);

        $this->inventoryUnitService->createInventoryUnit($createRequest);
        $response = $this->response;
        $response->redirect('inventory/inventory');
        $response->send();
    }

    public function updateAction() {
        $request = $this->request->getPost();
        $createRequest = new InventoryRequest();
        $createRequest->setId($request['id']);
        $createRequest->setName($request['name']);
        $createRequest->setType($request['type']);
        $createRequest->setDescription($request['description']);
        $createRequest->setQuantity($request['quantity']);
        $createRequest->setPrice($request['price']);
        $createRequest->setCategoryId($request['category_id']);
        $this->inventoryService->updateInventory($createRequest);
        $response = $this->response;
        $response->redirect('inventory/inventory');
        $response->send();
    }


}