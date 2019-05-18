<?php

namespace Core\Modules\Inventory\Orm;

use Core\Modules\Inventory\Entities\Inventory;

class ListOfInventory
{
    private $inventories;

    function addToList(Inventory $inventory){
        array_push($this->inventories, $inventory);
    }

    /**
     * @return mixed
     */
    public function getInventories()
    {
        return $this->inventories;
    }

}