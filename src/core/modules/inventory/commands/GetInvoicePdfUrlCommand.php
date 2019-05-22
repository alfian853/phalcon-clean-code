<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/22/19
 * Time: 11:40 AM
 */

namespace Core\Modules\Inventory\Commands;


use Core\Modules\Inventory\Orm\InventoryUnitRepository;
use Core\Modules\Inventory\Orm\ListOfInventoryUnit;
use Core\Modules\Inventory\Requests\CreateInvoiceRequest;
use Core\Modules\Inventory\Utils\InvoicePdfGenerator;
use DateTime;
use Phalcon\Exception;

class GetInvoicePdfUrlCommand
{

    private $unitRepository;
    private $pdfGenerator;
    /**
     * GetInventoryUnitTableCommand constructor.
     * @param InvoicePdfGenerator $pdfGenerator
     * @param InventoryUnitRepository $unitRepository
     */
    public function __construct(InvoicePdfGenerator $pdfGenerator ,InventoryUnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
        $this->pdfGenerator = $pdfGenerator;
    }

    public function execute(CreateInvoiceRequest $request){
        $grandTotal = 0;

        $listId = $request->getListId();
        $listOfUnit = new ListOfInventoryUnit();
        foreach ($listId as $id) {
            $unit = $this->unitRepository->findById($id);
            if ($unit == null) {
                throw new Exception('invalid request', 400);
            }
            $listOfUnit->addToList($unit);
            $grandTotal += $unit->getInventory()->getPrice();
        }

        $this->pdfGenerator->addData($listOfUnit, $grandTotal);
        $url = $this->pdfGenerator->render()->getDownloadUrl(time().'-invoice.pdf');

        return $url;
    }

}