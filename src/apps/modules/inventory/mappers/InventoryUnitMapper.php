<?php

namespace App\Inventory\Mappers;


use App\Inventory\Models\InventoryUnit;

class InventoryUnitMapper
{
    public static function mapping(InventoryUnit $unit) : \Core\Modules\Inventory\Entities\InventoryUnit
    {
        $result = new \Core\Modules\Inventory\Entities\InventoryUnit();
        $result->setId($unit->getIdentifier());
        $result->setInventory(InventoryMapper::mapping($unit->inventory));
        $result->setWarehouse(WarehouseMapper::mapping($unit->warehouse));
        return $result;
    }
}