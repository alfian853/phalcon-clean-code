<?php

namespace Core\Modules\Inventory\Commands;


use Core\Library\DataTablesResponse;
use Core\Library\Repositories\Criteria;
use Core\Library\Repositories\EntityField;
use Core\Library\Repositories\ListOfSearchCriteria;
use Core\Library\Repositories\SearchCriteria;
use Core\Library\Requests\DataTableRequest;
use Core\Modules\Inventory\Entities\Category;
use Core\Modules\Inventory\Entities\Inventory;
use Core\Modules\Inventory\Entities\InventoryUnit;
use Core\Modules\Inventory\Entities\Warehouse;
use Core\Modules\Inventory\Orm\InventoryUnitRepository;

class GetInventoryUnitTableCommand
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


    function execute(DataTableRequest $request){
        $criteria = new Criteria();
        $criteria->setPage($request->getStart()/$request->getLength());
        $criteria->setLength($request->getLength());

        $orderBy = $request->getOrderBy();

        if($orderBy == 'warehouse'){
            $criteria->setOrderBy(new EntityField(Warehouse::class,'name'));
        }
        else if($orderBy == 'id'){
            $criteria->setOrderBy(new EntityField(InventoryUnit::class, 'id'), $request->getOrderDir());
        }
        else if($orderBy == 'category'){
            $criteria->setOrderBy(new EntityField(Category::class, 'name'), $request->getOrderDir());
        }
        else{
            $criteria->setOrderBy(new EntityField(Inventory::class, 'name'), $request->getOrderDir());
        }

        $listOfSearch = new ListOfSearchCriteria();

        foreach ($request->getColumns() as $column){
            if($column['searchable']){
                switch ($column['name']){
                    case 'warehouse':
                        $listOfSearch->addToList(
                            new SearchCriteria(
                                new EntityField(Warehouse::class,'id'),$column['search'],true
                            )
                        );
                        break;
                    case 'id':
                        $listOfSearch->addToList(
                            new SearchCriteria(
                                new EntityField(InventoryUnit::class,'id'),$column['search']
                            )
                        );
                        break;
                    case 'category':
                        $listOfSearch->addToList(
                            new SearchCriteria(
                                new EntityField(Category::class,'name'),$column['search']
                            )
                        );
                        break;
                    case 'item':
                        $listOfSearch->addToList(
                            new SearchCriteria(
                                new EntityField(Inventory::class,'name'),$column['search']
                            )
                        );
                        break;
                    default:
                        $listOfSearch->addToList(
                            new SearchCriteria(
                                new EntityField(Inventory::class,$column['name']),$column['search']
                            )
                        );
                }
            }
        }

        $criteria->setSearchList($listOfSearch);

        $response = new DataTablesResponse();
        $queryResult = $this->unitRepository->findByCriteria($criteria);
        $response->setRecordsTotal($queryResult->getRecordsTotal());
        $response->setRecordsFiltered($queryResult->getRecordsFiltered());
        $response->setDraw($request->getDraw());

        $data = [];
        $inventoryUnits = $queryResult->getInventoryUnits();
        /** @var InventoryUnit $unit */
        foreach ($inventoryUnits as $unit){
            array_push(
                $data,
                [
                    'id' => $unit->getId(),
                    'item' => $unit->getInventory()->getName(),
                    'price' => $unit->getInventory()->getPrice(),
                    'warehouse' => $unit->getWarehouse()->getName(),
                    'category' => $unit->getInventory()->getCategory()->getName()
                ]
            );
        }

        $response->setData($data);
        return $response;
    }
}