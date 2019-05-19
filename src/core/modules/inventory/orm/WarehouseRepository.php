<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/18/19
 * Time: 4:39 PM
 */

namespace Core\Modules\Inventory\Orm;

use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Entities\Warehouse;

interface WarehouseRepository
{
    function findByCriteria(Criteria $criteria) : WarehousePaginationResult;

    function findById(int $warehouseId) : Warehouse;
    function deleteById(int $warehouseId);
    function createWarehouse(Warehouse $warehouse) : Warehouse;
    function updateWarehouse(Warehouse $warehouse) : bool;

}