<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/19/19
 * Time: 4:29 PM
 */

namespace Core\Modules\Inventory\Commands;


use Core\Modules\Inventory\Orm\InventoryUnitRepository;
use Core\Modules\Inventory\Utils\ItemDetailPdfGenerator;

class SendInventoryPdfCommand
{

    private $pdfGenerator, $unitRepository;

    /**
     * SendInventoryPdfCommand constructor.
     * @param ItemDetailPdfGenerator $pdfGenerator
     * @param InventoryUnitRepository $unitRepository
     */
    public function __construct(ItemDetailPdfGenerator $pdfGenerator, InventoryUnitRepository $unitRepository)
    {
        $this->pdfGenerator = $pdfGenerator;
        $this->unitRepository = $unitRepository;
    }

    public function execute(string $inventoryUnitId){
        $unit = $this->unitRepository->findById($inventoryUnitId);
        $this->pdfGenerator->addItemData($unit)->render()->sendPdfResponse("contoh.pdf");
    }
}