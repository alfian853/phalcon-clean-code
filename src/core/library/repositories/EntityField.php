<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/16/19
 * Time: 12:07 PM
 */

namespace Core\Library\Repositories;


class EntityField
{
    private $entityClass,$field;

    /**
     * OrderCriteria constructor.
     * @param $modelClass
     * @param $field
     */
    public function __construct($modelClass, $field)
    {
        $this->entityClass = $modelClass;
        $this->field = $field;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param mixed $entityClass
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }



}