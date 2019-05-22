<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/22/19
 * Time: 10:16 AM
 */

namespace Core\Modules\Inventory\Commands;


use Core\Library\Repositories\Criteria;
use Core\Library\Repositories\EntityField;
use Core\Library\Repositories\ListOfSearchCriteria;
use Core\Library\Repositories\SearchCriteria;
use Core\Modules\Inventory\Entities\Inventory;
use Core\Modules\Inventory\Entities\InventoryUnit;
use Core\Modules\Inventory\Entities\Warehouse;
use Core\Modules\Inventory\Orm\InventoryUnitRepository;
use Core\Modules\Inventory\Requests\ItemWarehouseSearchRequest;

class SearchItemWarehouseCommand
{

    private $unitRepository;

    /**
     * GetInventoryUnitTableCommand constructor.
     * @param $unitRepository
     */
    public function __construct(InventoryUnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function execute(ItemWarehouseSearchRequest $request){
        $criteria = new Criteria();
        $criteria->setPage($request->getPage());
        $criteria->setLength($request->getLength());
        $searchList = new ListOfSearchCriteria();
        $searchList->addToList(
            new SearchCriteria(new EntityField(Inventory::class,'name'),
                $request->getSearch())
        );
        $searchList->addToList(
            new SearchCriteria(new EntityField(Warehouse::class, 'id'),
                $request->getWarehouseId(),true)
        );

        $criteria->setSearchList($searchList);
        $queryResult = $this->unitRepository->findByCriteria($criteria);
        return [
            'recordsFiltered' => $queryResult->getRecordsFiltered(),
            'results' => array_map((function (InventoryUnit $result){
                return [
                    'id' => $result->getId(),
                    'name' => $result->getInventory()->getName(),
                    'price' => $result->getInventory()->getPrice(),
                    'warehouse_id' => $result->getWarehouse()->getId(),
                    'warehouse_name' => $result->getWarehouse()->getName()
                ];
            }), $queryResult->getInventoryUnits())
        ];


    }

}