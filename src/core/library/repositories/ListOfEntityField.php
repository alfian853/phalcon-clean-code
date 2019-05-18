<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/16/19
 * Time: 12:10 PM
 */

namespace Core\Library\Repositories;


class ListOfEntityField
{
    private $entitiesField = [];

    function addToList(EntityField $entityField){
        array_push($this->entitiesField, $entityField);
    }

    /**
     * @return array
     */
    public function getEntitiesField()
    {
        return $this->entitiesField;
    }

}