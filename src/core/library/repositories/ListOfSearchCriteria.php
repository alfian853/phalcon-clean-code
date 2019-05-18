<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/16/19
 * Time: 12:21 PM
 */

namespace Core\Library\Repositories;


class ListOfSearchCriteria
{
    private $list = [];

    function addToList(SearchCriteria $searchCriteria){
        array_push($this->list, $searchCriteria);
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }

}