<?php

namespace Core\Modules\Inventory\Orm;


use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Entities\Category;

interface CategoryRepository
{
    function findByCriteria(Criteria $request) : CategoryPaginationResult;

    function findById(int $id) : Category;
}