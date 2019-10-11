<?php

namespace Core\Modules\Inventory\Orm;


use Core\Modules\Inventory\Entities\Category;

class CategoryPaginationResult
{
    private $categories = [];

    private $recordsFiltered,$recordsTotal;

    function addToList(Category $category){
        array_push($this->categories, $category);
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
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