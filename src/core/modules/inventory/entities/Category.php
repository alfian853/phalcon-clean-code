<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/15/19
 * Time: 1:28 AM
 */

namespace Core\Modules\Inventory\Entities;


class Category
{
    private $id, $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}