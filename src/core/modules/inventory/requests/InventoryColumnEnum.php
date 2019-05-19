<?php

namespace Core\Modules\Inventory\Requests;


use Exception;

class InventoryColumnEnum
{
    const __default =  self::ID;

    const ID = 'id',
    NAME = 'name',
    PRICE = 'price',
    QUANTITY = 'quantity',
    CATEGORY = 'name',
    TYPE = 'type';

    static function getConst(string $column)
    {
        switch ($column) {
            case 'id':
                return InventoryColumnEnum::ID;
            case 'name':
                return InventoryColumnEnum::NAME;
            case 'price':
                return InventoryColumnEnum::PRICE;
            case 'quantity':
                return InventoryColumnEnum::QUANTITY;
            case 'type':
                return InventoryColumnEnum::TYPE;
            case 'category':
                return InventoryColumnEnum::CATEGORY;
            default:
                throw new Exception('unknown column', 400);
        }
    }

}

