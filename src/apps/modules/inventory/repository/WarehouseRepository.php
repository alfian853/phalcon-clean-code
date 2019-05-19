<?php

namespace App\Inventory\Repositories;


use App\Inventory\Mappers\WarehouseMapper;
use App\Inventory\Models\Warehouse;
use App\Inventory\Traits\CriteriaQueryTrait;
use App\Library\Orm\AbstractRepository;
use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Entities\Warehouse as CoreWarehouse;
use Core\Modules\Inventory\Orm\WarehousePaginationResult;
use Core\Modules\Inventory\Orm\WarehouseRepository as CoreWarehouseRepository;
use Phalcon\Mvc\Model\Query\Builder;

class WarehouseRepository extends AbstractRepository implements CoreWarehouseRepository
{

    use CriteriaQueryTrait;
    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return Warehouse::class;
    }

    function findByCriteria(Criteria $criteria): WarehousePaginationResult
    {
        /** @var Builder $builder */
        $builder = $this->getQueryBuilder();
        $paginate = $this->getPaginate($builder, $criteria);
        $items = $paginate->items;
        $result = new WarehousePaginationResult();
        foreach ($items as $item){
            $result->addToList(WarehouseMapper::mapping($item));
        }

        $result->setRecordsTotal($paginate->total_pages*$criteria->getLength());
        $result->setRecordsFiltered( $paginate->total_pages*$criteria->getLength());
        return $result;

    }

    function findById(int $warehouseId): CoreWarehouse
    {
        return WarehouseMapper::mapping(
            $this->findOne(['id' => $warehouseId])
        );
    }

    function deleteById(int $warehouseId)
    {
        // TODO: Implement deleteById() method.
    }

    function createWarehouse(CoreWarehouse $warehouse): CoreWarehouse
    {
        // TODO: Implement createWarehouse() method.
    }

    function updateWarehouse(CoreWarehouse $warehouse): bool
    {
        // TODO: Implement updateWarehouse() method.
    }
}