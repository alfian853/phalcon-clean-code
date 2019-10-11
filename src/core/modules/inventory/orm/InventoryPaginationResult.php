<?php

namespace Core\Modules\Inventory\Orm;


use Core\Modules\Inventory\Entities\Inventory;

class InventoryPaginationResult
{
    private $inventories = [];

    private $recordsFiltered,$recordsTotal;

    function addToList(Inventory $inventory){
        array_push($this->inventories, $inventory);
    }

    /**
     * @return array
     */
    public function getInventories()
    {
        return $this->inventories;
    }

    /**
     * @return mixed
     */
    public function getRecordsFiltered()
    {
        return $this->recordsFiltered;
    }

    /**
     * @param mixed $recordsFiltered
     */
    public function setRecordsFiltered(int $recordsFiltered)
    {
        $this->recordsFiltered = $recordsFiltered;
    }

    /**
     * @return mixed
     */
    public function getRecordsTotal()
    {
        return $this->recordsTotal;
    }

    /**
     * @param mixed $recordsTotal
     */
    public function setRecordsTotal(int $recordsTotal)
    {
        $this->recordsTotal = $recordsTotal;
    }




}