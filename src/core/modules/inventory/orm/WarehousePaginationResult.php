<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/19/19
 * Time: 5:09 AM
 */

namespace Core\Modules\Inventory\Orm;


use Core\Modules\Inventory\Entities\Warehouse;

class WarehousePaginationResult
{
    private $warehouses = [];

    private $recordsFiltered,$recordsTotal;

    public function addToList(Warehouse $unit){
        array_push($this->warehouses, $unit);
    }

    public function getWarehouses(){
        return $this->warehouses;
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