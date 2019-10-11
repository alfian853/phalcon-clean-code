<?php
namespace App\Inventory\Mappers;

use App\Inventory\Models\Inventory;

class InventoryMapper
{
    static function mapping(Inventory $model) : \Core\Modules\Inventory\Entities\Inventory
    {
        $res = new \Core\Modules\Inventory\Entities\Inventory();
        $res->setId($model->id);
        $res->setName($model->name);
        $res->setPrice($model->price);
        $res->setQuantity($model->quantity);
        $res->setDescription($model->description);
        $res->setType($model->type);
        $res->setCategory(CategoryMapper::mapping($model->category));
        return $res;
    }
}