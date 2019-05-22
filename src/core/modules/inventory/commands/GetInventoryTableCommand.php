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
use Core\Modules\Inventory\Orm\InventoryRepository;
use Core\Modules\Inventory\Requests\InventoryColumnEnum;
use Core\Modules\Inventory\Requests\InventoryTablesRequest;

class GetInventoryTableCommand
{
    private $repository;

    /**
     * GetInventoryTableCommand constructor.
     * @param InventoryRepository $repository
     */
    public function __construct(InventoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DataTableRequest $request
     * @return mixed
     */
    public function execute(DataTableRequest $request)
    {
        $criteria = new Criteria();
        $criteria->setPage($request->getStart()/$request->getLength());
        $criteria->setLength($request->getLength());

        $orderBy = $request->getOrderBy();

        switch ($orderBy){
            case 'category':
                $criteria->setOrderBy(new EntityField(Category::class,'name'));
                break;
            default:
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

        return $response;
    }
}