<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/18/19
 * Time: 2:03 PM
 */

namespace Core\Modules\Inventory\Orm;

use Core\Modules\Inventory\Entities\InventoryUnit;

class InventoryUnitPaginationResult
{
    private $inventories = [];

    private $recordsFiltered,$recordsTotal;

    public function addUnitToList(InventoryUnit $unit){
        array_push($this->inventories, $unit);
    }

    public function getInventoryUnits(){
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
    public function setRecordsFiltered($recordsFiltered)
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
    public function setRecordsTotal($recordsTotal)
    {
        $this->recordsTotal = $recordsTotal;
    }



}