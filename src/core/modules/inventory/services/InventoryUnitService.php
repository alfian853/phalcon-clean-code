<?php

namespace Core\Modules\Inventory\Services;


use Core\Modules\Inventory\Entities\InventoryUnit;
use Core\Modules\Inventory\Orm\InventoryRepository;
use Core\Modules\Inventory\Orm\InventoryUnitRepository;
use Core\Modules\Inventory\Orm\WarehouseRepository;
use Core\Modules\Inventory\Requests\InventoryUnitRequest;

class InventoryUnitService
{
    private $inventoryRepository,
            $warehouseRepository,
            $inventoryUnitRepository;

    /**
     * InventoryUnitService constructor.
     * @param $inventoryRepository
     * @param $warehouseRepository
     * @param $inventoryUnitRepository
     */
    public function __construct(InventoryRepository $inventoryRepository,
                                WarehouseRepository $warehouseRepository,
                                InventoryUnitRepository $inventoryUnitRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->inventoryUnitRepository = $inventoryUnitRepository;
    }


    public function createInventoryUnit(InventoryUnitRequest $request){

        $inventory = $this->inventoryRepository->findById($request->getInventoryId());
        if($inventory == null){
            throw new \Exception("inventory not found",404);
        }

        $warehouse = $this->warehouseRepository->findById($request->getWarehouseId());
        if($warehouse == null){
            throw new \Exception("warehouse not found",404);
        }

        $unit = new InventoryUnit();
        $unit->setInventory($inventory);
        $unit->setWarehouse($warehouse);

        $this->inventoryUnitRepository->createInventoryUnit($unit);
    }
}