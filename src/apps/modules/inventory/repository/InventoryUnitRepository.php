<?php

namespace App\Inventory\Repositories;

use App\Inventory\Mappers\InventoryUnitMapper;
use App\Inventory\Models\Category;
use App\Inventory\Models\Inventory;
use App\Inventory\Models\InventoryUnit;
use App\Inventory\Models\Warehouse;
use App\Inventory\Traits\CriteriaQueryTrait;
use Core\Modules\Inventory\Entities\InventoryUnit as CoreInventoryUnit;
use App\Library\Orm\AbstractRepository;
use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Orm\InventoryUnitPaginationResult;
use Core\Modules\Inventory\Orm\InventoryUnitRepository as CoreInventoryUnitRepository;
use Core\Modules\Inventory\Orm\WarehouseRepository;
use Phalcon\Mvc\Model\Query\Builder;

class InventoryUnitRepository extends AbstractRepository implements CoreInventoryUnitRepository
{
    use CriteriaQueryTrait;

    private $inventoryRepository, $warehouseRepository;

    /**
     * InventoryUnitRepository constructor.
     * @param InventoryRepository $inventoryRepository
     * @param WarehouseRepository $warehouseRepository
     */
    public function __construct(InventoryRepository $inventoryRepository, WarehouseRepository $warehouseRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
        $this->warehouseRepository = $warehouseRepository;
        parent::__construct();
    }

    function findByCriteria(Criteria $criteria): InventoryUnitPaginationResult
    {
        /** @var Builder $builder */
        $builder = $this->getQueryBuilder();
        $builder->join(Warehouse::class,Warehouse::class.'.id = warehouse_id');
        $builder->join(Inventory::class,Inventory::class.'.id = inventory_id');
        $builder->join(Category::class,Category::class.'.id = '.Inventory::class.'.category_id');
        $paginate = $this->getPaginate($builder, $criteria);
        $items = $paginate->items;
        $result = new InventoryUnitPaginationResult();
        foreach ($items as $item){
            $result->addUnitToList(InventoryUnitMapper::mapping($item));
        }

        $result->setRecordsTotal($paginate->total_pages*$criteria->getLength());
        $result->setRecordsFiltered( $paginate->total_pages*$criteria->getLength());
        return $result;
    }

    function findById(int $inventoryUnitId): CoreInventoryUnit
    {
        return InventoryUnitMapper::mapping(
            $this->findOne(['id' => $inventoryUnitId])
        );
    }

    function deleteById(int $inventoryUnitId)
    {
        // TODO: Implement deleteById() method.
    }

    function createInventoryUnit(CoreInventoryUnit $coreInventoryUnit): CoreInventoryUnit
    {
        $inventoryUnit = $this->create([
            'id' => uniqid(),
            'warehouse_id' => $coreInventoryUnit->getWarehouse()->getId(),
            'inventory_id' => $coreInventoryUnit->getInventory()->getId(),
            'rack' => $coreInventoryUnit->getRack()
        ]);
        $result = new CoreInventoryUnit();
        $result->setId($inventoryUnit->id);

        $result->setWarehouse(
            $this->warehouseRepository->findById($coreInventoryUnit->getWarehouse()->getId())
        );

        $result->setInventory(
            $this->inventoryRepository->findById($coreInventoryUnit->getInventory()->getId())
        );

        return $result;
    }

    function updateInventoryUnit(CoreInventoryUnit $inventoryUnit): bool
    {
        // TODO: Implement updateInventoryUnit() method.
    }

    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return InventoryUnit::class;
    }
}