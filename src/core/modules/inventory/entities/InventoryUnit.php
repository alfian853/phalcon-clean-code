<?php

namespace Core\Modules\Inventory\Entities;


class InventoryUnit
{
    private $id;
    private $inventory;
    private $warehouse;
    private $rack;

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

    /**
     * @return mixed
     */
    public function getInventory() : Inventory
    {
        return $this->inventory;
    }

    /**
     * @param mixed $inventory
     */
    public function setInventory(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * @return mixed
     */
    public function getWarehouse() : Warehouse
    {
        return $this->warehouse;
    }

    /**
     * @param mixed $warehouse
     */
    public function setWarehouse(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * @return mixed
     */
    public function getRack()
    {
        return $this->rack;
    }

    /**
     * @param mixed $rack
     */
    public function setRack($rack)
    {
        $this->rack = $rack;
    }


}