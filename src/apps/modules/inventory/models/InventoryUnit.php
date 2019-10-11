<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/18/19
 * Time: 2:17 PM
 */

namespace App\Inventory\Models;


use App\Library\Orm\BaseModel;

class InventoryUnit extends BaseModel
{
    private $id;

    public function initialize()
    {
        $this->setSource('inventory_units');
        $this->belongsTo('inventory_id',Inventory::class,'id',
            array('alias' => 'Inventory'));
        $this->belongsTo('warehouse_id','App\Inventory\Models\Warehouse','id',
            array('alias' => 'Warehouse'));
    }

    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}