<?php
namespace Core\Modules\Inventory\Orm;

use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Entities\Inventory;

/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/16/19
 * Time: 1:25 PM
 */

interface InventoryRepository
{
    function findByCriteria(Criteria $request) : InventoryPaginationResult;

    function findById(int $inventoryId) : Inventory;
    function deleteById(int $inventoryId);
    function createInventory(Inventory $inventory) : Inventory;
    function updateInventory(Inventory $inventory) : bool;

}