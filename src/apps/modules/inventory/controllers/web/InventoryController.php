<?php
namespace App\Inventory\Controllers\Web;

use Core\Library\Commands\CommandContainer;
use Core\Modules\Inventory\Requests\InventoryRequest;
use Core\Modules\Inventory\Services\InventoryService;
use Phalcon\Mvc\Controller;
use Dompdf\Dompdf;
use Phalcon\Mvc\View\Simple;

/**
 * Class InventoryController
 * @property CommandContainer commands injected into DI
 * @property InventoryService inventoryService injected into DI
 * @property Simple view2
 */
class InventoryController extends Controller
{

    public function indexAction() {
        return $this->view->pick('inventory_table');
    }

    public function createAction() {
        $request = $this->request->getPost();
        $createRequest = new InventoryRequest();
        $createRequest->setName($request['name']);
        $createRequest->setType($request['type']);
        $createRequest->setDescription($request['description']);
        $createRequest->setQuantity($request['quantity']);
        $createRequest->setPrice($request['price']);
        $createRequest->setCategoryId($request['category_id']);

        $this->inventoryService->createInventory($createRequest);
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

    public function deleteAction() {
        $this->inventoryService->deleteInventory($this->request->getPost('inventory_id'));
        $this->response->redirect('/inventory/inventory')->send();
    }

    public function manaAction(){
        $dompdf = new DOMPDF();  //if you use namespaces you may use new \DOMPDF()

        $this->simpleView->setVar("nama","alfian");
        $dompdf->loadHtml($this->simpleView->render("tes_pdf"));
        $dompdf->render();
        $dompdf->stream("sample.pdf", array("Attachment"=>0));
    }

}