<?php

namespace Core\Modules\Inventory\Commands;


use Core\Library\Repositories\Criteria;
use Core\Library\Repositories\EntityField;
use Core\Library\Requests\DataTableRequest;
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

        if($orderBy == ''){
            $criteria->setOrderBy(new EntityField(Category::class,'name'));
        }
        else{
            $criteria->setOrderBy(new EntityField(Inventory::class, $orderBy), $request->getOrderDir());
        }

        $listOfSearch = new ListOfSearchCriteria();

        foreach ($request->getColumns() as $column){
            if($column['searchable']){
                switch ($column['name']){
                    case 'category':
                        $listOfSearch->addToList(
                            new SearchCriteria(
                                new EntityField(Category::class,'name'),$column['search']
                            )
                        );
                        break;
                    case 'action':
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
        $queryResult = $this->repository->findByCriteria($criteria);
        $response->setRecordsTotal($queryResult->getRecordsTotal());
        $response->setRecordsFiltered($queryResult->getRecordsFiltered());
        $response->setDraw($request->getDraw());

        $data = [];
        $inventories = $queryResult->getInventories();
        /** @var Inventory $inventory */
        foreach ($inventories as $inventory){
            array_push(
                $data,
                [
                    'id' => $inventory->getId(),
                    'name' => $inventory->getName(),
                    'price' => $inventory->getPrice(),
                    'quantity' => $inventory->getQuantity(),
                    'category' => $inventory->getCategory()->getName(),
                    'type' => $inventory->getType()
                ]
            );
        }

        $response->setData($data);
    }
}