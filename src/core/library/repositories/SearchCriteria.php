<?php

namespace Core\Library\Repositories;


class SearchCriteria
{
    public $entityField;
    public $data;
    public $isEqualSearch = false;

    /**
     * SearchCriteria constructor.
     * @param EntityField $entityField
     * @param $data
     * @param bool $isEqualSearch
     */
    public function __construct(EntityField $entityField, $data, $isEqualSearch = false)
    {
        $this->entityField = $entityField;
        $this->data = $data;
        $this->isEqualSearch = $isEqualSearch;
    }

    /**
     * @return EntityField
     */
    public function getEntityField(): EntityField
    {
        return $this->entityField;
    }

    /**
     * @param EntityField $entityField
     */
    public function setEntityField(EntityField $entityField)
    {
        $this->entityField = $entityField;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function setEqualSearch(){
        $this->isEqualSearch = true;
    }

    public function setSubstringSearch(){
        $this->isEqualSearch = false;
    }


}