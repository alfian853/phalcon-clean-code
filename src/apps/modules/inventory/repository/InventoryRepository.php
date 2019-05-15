<?php
namespace App\Inventory\Repositories;

use App\Inventory\Models\Category;
use App\Inventory\Models\Inventory;
use App\Library\Orm\AbstractRepository;
use Core\Library\DataTablesResponse;
use Core\Library\DataTables\Criteria;
use Core\Library\DataTables\DataTablesRepositoryInterface;
use Core\Library\DataTables\SearchCriteria;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Paginator\Factory;

class InventoryRepository extends AbstractRepository implements DataTablesRepositoryInterface
{

    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return Inventory::class;
    }

    private function getFieldFromColumn($field){
        $strings = explode('.',$field);
        if(count($strings) == 1){
            return Inventory::class.'.'.$field;
        }
        switch ($strings[0]){
            case 'categories':
                return Category::class.'.'.$strings[1];
                break;
            case 'inventories':
                return Inventory::class.'.'.$strings[1];
                break;
        }
        throw new \Phalcon\Exception('bad request',400);
    }

    function mapResponse($item){
        return [
            'id' => $item->id,
            'name' => $item->name,
            'category' => $item->category->name,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'type' => $item->type
        ];
    }

    function findByDataTablesRequest(Criteria $criteria)
    {
        /** @var Builder $builder */
        $builder = $this->getQueryBuilder();
        $builder->join(Category::class,Category::class.'.id = category_id');

        /** @var SearchCriteria $search */
        foreach ($criteria->search_list as $search){
            $field = $this->getFieldFromColumn($search->field);
            $builder->andWhere('cast('.$field.' as TEXT) like \'%'.$search->data.'%\'');
        }
        $builder->orderBy($this->getFieldFromColumn($criteria->orderBy).' '.$criteria->orderDir);
        $options =
            [
                'builder'  => $builder,
                'limit' => $criteria->length,
                'page'  => $criteria->page,
                'adapter' => 'queryBuilder'
            ];
        $paginate = Factory::load($options)->getPaginate();
        $items = $paginate->items;
        $res = [];
        foreach ($items as $item){
            array_push($res, $this->mapResponse($item));
        }
        $result = new DataTablesResponse();
        $result->recordsFiltered =  $paginate->total_pages*$criteria->length;
        $result->recordsTotal = $paginate->total_pages * $criteria->length;
        $result->data = $res;

        return $result;
    }
}