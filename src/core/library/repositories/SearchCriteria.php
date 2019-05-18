<?php

namespace Core\Library\Repositories;


class SearchCriteria
{
    public $entityField;
    public $data;

    /**
     * SearchCriteria constructor.
     * @param $entityField
     * @param $data
     */
    public function __construct(EntityField $entityField, $data)
    {
        $this->entityField = $entityField;
        $this->data = $data;
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



}