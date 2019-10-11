<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/15/19
 * Time: 6:59 PM
 */

namespace App\Inventory\Repositories;

use App\Inventory\Mappers\CategoryMapper;
use App\Inventory\Traits\CriteriaQueryTrait;
use App\Inventory\Models\Category;
use App\Library\Orm\AbstractRepository;
use Core\Library\Repositories\Criteria;
use Core\Modules\Inventory\Entities\Category as CoreCategory;
use Core\Modules\Inventory\Orm\CategoryRepository as CategoryCoreRepository;
use Core\Modules\Inventory\Orm\CategoryPaginationResult;

class CategoryRepository extends AbstractRepository implements CategoryCoreRepository
{

    use CriteriaQueryTrait;
    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        // TODO: Implement modelName() method.
        return Category::class;
    }

    function findByCriteria(Criteria $criteria) : CategoryPaginationResult
    {
        $builder = $this->getQueryBuilder();

        $paginate = $this->getPaginate($builder, $criteria);

        $items = $paginate->items;
        $result = new CategoryPaginationResult();
        $result->setRecordsTotal($paginate->total_pages*$criteria->getLength());
        $result->setRecordsFiltered($paginate->total_pages*$criteria->getLength());
        foreach ($items as $item){
            $result->addToList(CategoryMapper::mapping($item));
        }

        return $result;
    }

    function findById(int $id): CoreCategory
    {
        // TODO: Implement findById() method.
        return CategoryMapper::mapping(
            $this->findOne(['id' => $id])
        );
    }
}