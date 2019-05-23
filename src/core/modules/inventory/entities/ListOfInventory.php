<?php

namespace Core\Modules\Inventory\Entities;

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