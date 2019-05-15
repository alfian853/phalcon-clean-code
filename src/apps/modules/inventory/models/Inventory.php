<?php

namespace App\Inventory\Models;


use App\Library\Orm\BaseModel;

/**
 * @property int id
 * @property string name
 * @property string email
 */

class Inventory extends BaseModel
{
    public $id;

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