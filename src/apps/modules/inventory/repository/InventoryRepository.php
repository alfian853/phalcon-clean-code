<?php
namespace App\Inventory\Repositories;

use App\Inventory\Mappers\InventoryMapper;
use App\Inventory\Models\Category;
use App\Inventory\Models\Inventory;
use App\Inventory\Traits\CriteriaQueryTrait;
use App\Library\Orm\AbstractRepository;
use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Entities\Inventory as CoreInventory;
use Core\Modules\Inventory\Orm\InventoryRepository as InventoryCoreRepository;
use Core\Modules\Inventory\Orm\InventoryPaginationResult;
use Phalcon\Mvc\Model\Query\Builder;

class InventoryRepository extends AbstractRepository implements InventoryCoreRepository
{

    use CriteriaQueryTrait;
    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return Inventory::class;
    }


    function findByCriteria(Criteria $criteria) : InventoryPaginationResult
    {
        /** @var Builder $builder */
        $builder = $this->getQueryBuilder();
        $builder->join(Category::class,Category::class.'.id = category_id');

        $paginate = $this->getPaginate($builder, $criteria);
        $items = $paginate->items;
        $result = new InventoryPaginationResult();
        foreach ($items as $item){
            $result->addToList(InventoryMapper::mapping($item));
        }
        $result->setRecordsTotal($paginate->total_pages*$criteria->getLength());
        $result->setRecordsFiltered( $paginate->total_pages*$criteria->getLength());
        return $result;
    }

    function createInventory(CoreInventory $inventory) : CoreInventory
    {
        $res = $this->create([
            'name' => $inventory->getName(),
            'price' => $inventory->getPrice(),
            'quantity' => $inventory->getQuantity(),
            'type' => $inventory->getType(),
            'category_id' => $inventory->getCategory()->getId(),
            'description' => $inventory->getDescription()
        ]);
        $inventory->setId($this->model->id);
        return $inventory;
    }

    function updateInventory(CoreInventory $inventory) : bool
    {
        return $this->update([
            'id' => $inventory->getId()],
            [
                'name' => $inventory->getName(),
                'price' => $inventory->getPrice(),
                'quantity' => $inventory->getQuantity(),
                'type' => $inventory->getType(),
                'category_id' => $inventory->getCategory()->getId()
            ]
        ) instanceof Inventory;
    }


    function findById(int $inventoryId): CoreInventory
    {
        return InventoryMapper::mapping($this->findOne(['id' => $inventoryId]));
    }

    function deleteById(int $inventoryId)
    {
        return $this->delete($inventoryId);
    }
}