<?php

namespace App\Inventory\Models;


use App\Library\Orm\BaseModel;

/**
 * @property int id
 * @property string name
 * @property string email
 */

class Category extends BaseModel
{

    public function initialize()
    {
        $this->setSource('categories');
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}