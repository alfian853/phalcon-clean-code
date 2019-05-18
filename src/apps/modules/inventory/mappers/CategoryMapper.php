<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/17/19
 * Time: 4:47 AM
 */

namespace App\Inventory\Mappers;


use App\Inventory\Models\Category;

class CategoryMapper
{
    static function mapping(Category $category) : \Core\Modules\Inventory\Entities\Category
    {
        $result = new \Core\Modules\Inventory\Entities\Category();
        $result->setId($category->id);
        $result->setName($category->name);
        return $result;
    }
}