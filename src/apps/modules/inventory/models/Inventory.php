<?php

namespace App\Inventory\Models;

use App\Library\Orm\BaseModel;

class Inventory extends BaseModel
{
    public $id,
        $name,
        $price,
        $quantity,
        $description,
        $type;
//        $category;


    public function initialize()
    {
        $this->setSource('inventories');
        $this->belongsTo('category_id','App\Inventory\Models\Category','id',
            array('alias' => 'Category'));
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}