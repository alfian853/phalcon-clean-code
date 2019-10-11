<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/15/19
 * Time: 6:58 PM
 */

namespace App\Inventory\Controllers\Api;


use Core\Library\Commands\CommandContainer;
use Core\Library\Requests\SearchRequest;
use Core\Modules\Inventory\Commands\SearchCategoriesCommand;
use Phalcon\Mvc\Controller;

/**
 * Class CategoryController
 * @property CommandContainer commands injected into DI
 */

class CategoryController extends Controller
{

    private function sendResponse($res){
        $response = $this->response;
        $response->setContentType('application/json');
        $response->setContent(json_encode($res));
        $response->send();
    }

    function searchAction(){
        $request = $this->request->getQuery();
        $searhReq = new SearchRequest();
        $searhReq->setLength($request['length']);
        $searhReq->setPage($request['page']);
        $searhReq->setSearch($request['search']);
        $this->sendResponse(
            $this->commands->get(SearchCategoriesCommand::class)->execute($searhReq)
        );
    }
}