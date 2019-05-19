<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/19/19
 * Time: 4:42 AM
 */

namespace Core\Modules\Inventory\Commands;


use Core\Library\Repositories\Criteria;
use Core\Library\Repositories\EntityField;
use Core\Library\Repositories\ListOfSearchCriteria;
use Core\Library\Repositories\SearchCriteria;
use Core\Library\Requests\SearchRequest;
use Core\Modules\Inventory\Entities\Inventory;
use Core\Modules\Inventory\Orm\InventoryRepository;

class SearchInventoriesCommand
{

    private $inventoryRepository;

    /**
     * SearchInventoriesCommand constructor.
     * @param $inventoryRepository
     */
    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }


    function execute(SearchRequest $request){
        $criteria = new Criteria();
        $criteria->setPage($request->getPage());
        $criteria->setLength($request->getLength());
        $searchList = new ListOfSearchCriteria();
        $searchList->addToList(
            new SearchCriteria(new EntityField(Inventory::class,'name'),
                $request->getSearch())
        );
        $criteria->setSearchList($searchList);
        $queryResult = $this->inventoryRepository->findByCriteria($criteria);
        return [
            'recordsFiltered' => $queryResult->getRecordsFiltered(),
            'results' => array_map((function (Inventory $result){
                return [
                    'id' => $result->getId(),
                    'text' => $result->getName()
                ];
            }), $queryResult->getInventories())
        ];
    }
}