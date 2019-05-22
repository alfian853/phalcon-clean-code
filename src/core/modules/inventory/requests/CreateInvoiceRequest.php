<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/22/19
 * Time: 11:41 AM
 */

namespace Core\Modules\Inventory\Requests;


class CreateInvoiceRequest
{
    private $listId = array();


    function addIdToList(string $id){
        array_push($this->listId, $id);
    }

    /**
     * @return array
     */
    public function getListId(): array
    {
        return $this->listId;
    }

}