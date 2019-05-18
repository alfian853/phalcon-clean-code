<?php

namespace Core\Modules\Inventory\Commands;

use Core\Library\Repositories\Criteria;
use Core\Library\Repositories\CriteriaRepositoryInterface;
use Core\Library\Repositories\EntityField;
use Core\Library\Repositories\ListOfSearchCriteria;
use Core\Library\Repositories\SearchCriteria;
use Core\Library\Requests\SearchRequest;
use Core\Modules\Inventory\Entities\Category;
use Core\Modules\Inventory\Orm\CategoryRepository;

class SearchCategoriesCommand
{

    private $repository;

    /**
     * SearchCategoriesCommand constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    private function mapToSearchResult(Category $result){
        return [
            'id' => $result->getId(),
            'text' => $result->getName()
        ];
    }

    public function execute(SearchRequest $request)
    {
        // TODO: Implement execute() method.
        $criteria = new Criteria();
        $criteria->setPage($request->getPage());
        $criteria->setLength($request->getLength());
        $searchList = new ListOfSearchCriteria();
        $searchList->addToList(
            new SearchCriteria(new EntityField(Category::class,'name'),
            $request->getSearch())
        );
        $criteria->setSearchList($searchList);
        $queryResult = $this->repository->findByCriteria($criteria);
        return [
            'recordsFiltered' => $queryResult->getRecordsFiltered(),
            'results' => array_map((function (Category $result){
                return [
                    'id' => $result->getId(),
                    'text' => $result->getName()
                ];
            }), $queryResult->getCategories())
        ];
    }
}