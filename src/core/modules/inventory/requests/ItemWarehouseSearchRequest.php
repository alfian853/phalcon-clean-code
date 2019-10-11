<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/22/19
 * Time: 10:12 AM
 */

namespace Core\Modules\Inventory\Requests;


use Core\Library\Requests\SearchRequest;

class ItemWarehouseSearchRequest extends SearchRequest
{
    private $warehouse_id;

    /**
     * @return mixed
     */
    public function getWarehouseId()
    {
        return $this->warehouse_id;
    }

    /**
     * @param mixed $warehouse_id
     */
    public function setWarehouseId($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

}