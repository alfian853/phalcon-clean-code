<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/22/19
 * Time: 11:44 AM
 */

namespace Core\Modules\Inventory\Orm;


use Core\Modules\Inventory\Entities\InventoryUnit;

class ListOfInventoryUnit
{
    private $list = array();


    public function addToList(InventoryUnit $unit){
        array_push($this->list, $unit);
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }


}