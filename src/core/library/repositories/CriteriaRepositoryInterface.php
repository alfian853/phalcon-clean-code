<?php

namespace Core\Library\Repositories;


use Core\Modules\Inventory\Entities\InventoryPaginationResult;

interface CriteriaRepositoryInterface
{
    function findByCriteria(Criteria $request) : InventoryPaginationResult;
}