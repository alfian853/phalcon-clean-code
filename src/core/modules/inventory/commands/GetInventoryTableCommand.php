<?php

namespace Core\Modules\Inventory\Commands;


use Core\Library\Commands\CommandInterface;
use Core\Library\DataTables\Criteria;
use Core\Library\DataTables\DataTablesRepositoryInterface;
use Core\Library\DataTables\SearchCriteria;

class GetInventoryTableCommand implements CommandInterface
{


    private $repository;

    /**
     * GetInventoryTableCommand constructor.
     * @param DataTablesRepositoryInterface $repository
     */
    public function __construct(DataTablesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute($request = null)
    {
        $criteria = new Criteria();
        $criteria->page = $request['start']/$request['length'];
        $criteria->length = $request['length'];
        $orderBy = $request['columns'][$request['order'][0]['column']]['name'];
        if($orderBy == 'category'){
            $criteria->orderBy = 'categories.name';
        }
        else{
            $criteria->orderBy = 'inventories.'.$orderBy;
        }
        $criteria->orderDir = $request['order'][0]['dir'];
        foreach ($request['columns'] as $query){
            if($query['searchable']){
                switch ($query['name']){
                    case 'category':
                        array_push($criteria->search_list,
                            new SearchCriteria('categories.name',$query['search']['value']));
                        break;
                    case 'action':
                        break;
                    default:
                        array_push($criteria->search_list,
                            new SearchCriteria('inventories.'.$query['name'],$query['search']['value']));
                }
            }
        }

        $res = $this->repository->findByDataTablesRequest($criteria);
        $res->draw = $request['draw'];
        return $res;
    }
}