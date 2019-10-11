<?php
namespace Core\Modules\Inventory\Orm;

use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Entities\InventoryUnit;

/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/16/19
 * Time: 1:25 PM
 */

interface InventoryUnitRepository
{
    function findByCriteria(Criteria $request) : InventoryUnitPaginationResult;

    function findById(string $inventoryUnitId) : InventoryUnit;
    function deleteById(string $inventoryUnitId) : bool;
    function createInventoryUnit(InventoryUnit $InventoryUnitUnit) : InventoryUnit;
//    function updateInventoryUnit(InventoryUnit $inventoryUnit) : bool;

}