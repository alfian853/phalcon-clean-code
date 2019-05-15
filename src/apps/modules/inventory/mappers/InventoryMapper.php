<?php
namespace App\Inventory\Mappers;

use App\Inventory\Models\Inventory;

class InventoryMapper
{
    function getDto($model){
        return [
            'name' => $model->name,
            'price' => $model->price,
            'quantity' => $model->quantity,
            'category' => $model->category->name,
            'type' => $model->type
        ];
    }
}