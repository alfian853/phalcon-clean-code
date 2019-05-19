<?php

namespace Core\Modules\Inventory\Commands;


use Core\Library\Repositories\Criteria;
use Core\Library\Repositories\EntityField;
use Core\Library\Repositories\ListOfSearchCriteria;
use Core\Library\Repositories\SearchCriteria;
use Core\Library\Requests\SearchRequest;
use Core\Modules\Inventory\Entities\Inventory;
use Core\Modules\Inventory\Entities\Warehouse;
use Core\Modules\Inventory\Orm\WarehouseRepository;

class SearchWarehousesCommand
{

    private $warehouseRepository;

    /**
     * SearchInventoriesCommand constructor.
     * @param $warehouseRepository
     */
    public function __construct(WarehouseRepository $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }


    function execute(SearchRequest $request){
        $criteria = new Criteria();
        $criteria->setPage($request->getPage());
        $criteria->setLength($request->getLength());
        $searchList = new ListOfSearchCriteria();
        $searchList->addToList(
            new SearchCriteria(new EntityField(Warehouse::class,'name'),
                $request->getSearch())
        );
        $criteria->setSearchList($searchList);
        $queryResult = $this->warehouseRepository->findByCriteria($criteria);
        return [
            'recordsFiltered' => $queryResult->getRecordsFiltered(),
            'results' => array_map((function (Warehouse $result){
                return [
                    'id' => $result->getId(),
                    'text' => $result->getName()
                ];
            }), $queryResult->getWarehouses())
        ];
    }
}