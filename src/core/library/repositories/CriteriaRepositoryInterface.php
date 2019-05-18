<?php

namespace Core\Library\Repositories;


use Core\Modules\Inventory\Orm\InventoryPaginationResult;

interface CriteriaRepositoryInterface
{
    function findByCriteria(Criteria $request) : InventoryPaginationResult;
}