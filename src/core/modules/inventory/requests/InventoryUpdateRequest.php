<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/18/19
 * Time: 2:56 AM
 */
namespace Core\Modules\Inventory\Requests;

class InventoryUpdateRequest
{
    private
        $id,
        $name, $nameUpdate = false,
        $quantity, $quantityUpdate = false,
        $price, $priceUpdate = false,
        $description, $descriptionUpdate = false,
        $type, $typeUpdate = false,
        $category_id, $categoryUpdate = false;

    /**
     * @return bool
     */
    public function isNameUpdate(): bool
    {
        return $this->nameUpdate;
    }

    /**
     * @return bool
     */
    public function isQuantityUpdate(): bool
    {
        return $this->quantityUpdate;
    }

    /**
     * @return bool
     */
    public function isPriceUpdate(): bool
    {
        return $this->priceUpdate;
    }

    /**
     * @return bool
     */
    public function isDescriptionUpdate(): bool
    {
        return $this->descriptionUpdate;
    }

    /**
     * @return bool
     */
    public function isTypeUpdate(): bool
    {
        return $this->typeUpdate;
    }

    /**
     * @return bool
     */
    public function isCategoryUpdate(): bool
    {
        return $this->categoryUpdate;
    }

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
        $this->nameUpdate = true;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->quantityUpdate = true;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->priceUpdate = true;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        $this->descriptionUpdate = true;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->typeUpdate = true;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
        $this->categoryUpdate = true;
    }


}