<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/18/19
 * Time: 2:46 PM
 */

namespace App\Inventory\Mappers;


use App\Inventory\Models\Warehouse;

class WarehouseMapper
{
    public static function mapping(Warehouse $warehouse) : \Core\Modules\Inventory\Entities\Warehouse{
        $res = new \Core\Modules\Inventory\Entities\Warehouse();
        $res->setId($warehouse->getId());
        $res->setName($warehouse->getName());
        $res->setAddress($warehouse->getAddress());
        return $res;
    }
}