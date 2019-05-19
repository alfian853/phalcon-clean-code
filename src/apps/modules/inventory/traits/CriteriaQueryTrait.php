<?php
namespace App\Inventory\Traits;


use Core\Library\Repositories\Criteria;
use Core\Library\Repositories\EntityField;
use Core\Library\Repositories\SearchCriteria;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Paginator\Factory;

trait CriteriaQueryTrait
{

    private function getFieldFromColumn(EntityField $entityField){
        switch ($entityField->getEntityClass()){
            case \Core\Modules\Inventory\Entities\Category::class:
                return \App\Inventory\Models\Category::class;
            case \Core\Modules\Inventory\Entities\Inventory::class:
                return \App\Inventory\Models\Inventory::class;
            case \Core\Modules\Inventory\Entities\InventoryUnit::class:
                return \App\Inventory\Models\InventoryUnit::class;
            case \Core\Modules\Inventory\Entities\Warehouse::class:
                return \App\Inventory\Models\Warehouse::class;
        }
        return null;
    }

    /**
     * @param Builder $builder
     * @param Criteria $criteria
     * @return \stdClass
     */
    function getPaginate(Builder $builder, Criteria $criteria){
        /** @var SearchCriteria $search */
        foreach ($criteria->getSearchList()->getList() as $search){
            $field = $this->getFieldFromColumn($search->getEntityField());
            $builder->andWhere('cast('.$field.'.'.
                $search->getEntityField()->getField().' as TEXT) like \'%'.$search->getData().'%\'');
        }
        if($criteria->getOrderBy()){
            $builder->orderBy($this->getFieldFromColumn(
                $criteria->getOrderBy()).'.'.$criteria->getOrderBy()->getField()
                .' '.$criteria->getOrderDir());
        }
        $options =
            [
                'builder'  => $builder,
                'limit' => $criteria->getLength(),
                'page'  => $criteria->getPage(),
                'adapter' => 'queryBuilder'
            ];
        return Factory::load($options)->getPaginate();
    }

}