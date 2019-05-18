<?php

namespace Core\Library\Repositories;


class Criteria
{
    private $page,$length;
    private $orderBy,$orderDir = 'desc';
    private $searchList;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return EntityField
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     * @param string $orderDir
     */
    public function setOrderBy(EntityField $orderBy, $orderDir = 'desc')
    {
        $this->orderBy = $orderBy;
        $this->orderDir = $orderDir;
    }

    /**
     * @return mixed
     */
    public function getOrderDir()
    {
        return $this->orderDir;
    }

    /**
     * @param mixed $orderDir
     */
    public function setOrderDir($orderDir)
    {
        $this->orderDir = $orderDir;
    }

    /**
     * @return ListOfSearchCriteria
     */
    public function getSearchList() : ListOfSearchCriteria
    {
        return $this->searchList;
    }

    /**
     * @param ListOfSearchCriteria $searchList
     */
    public function setSearchList(ListOfSearchCriteria $searchList)
    {
        $this->searchList = $searchList;
    }



}