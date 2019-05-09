<?php

namespace App\BookLibrary\Controllers\Api;


use App\BookLibrary\Commands\AddAuthorCommand;
use App\BookLibrary\Commands\GetAuthorCommand;
use App\BookLibrary\Request\AddAuthorRequest;
use Phalcon\Mvc\Controller;

/**
 * Class AuthorController
 * @property \App\Library\Commands\Container commands injected into DI
 */
class AuthorController extends Controller
{
    public function indexAction(){
        $request = $this->request;
        $response = $this->response;
        $response->setContentType('application/json');
        switch ($request->getMethod()){
            case 'POST':
                $jsonBody = $request->getJsonRawBody();
                $addAuthorReq = new AddAuthorRequest();
                $addAuthorReq->setName($jsonBody->name);
                $addAuthorReq->setEmail($jsonBody->email);
                $response->setContent(json_encode([
                        'success' => $this->commands->get(AddAuthorCommand::class)
                                    ->execute($addAuthorReq)
                    ])
                );
                $response->send();
                break;
            case 'GET':
                $response->setContent(
                    json_encode(
                        $this->commands->get(GetAuthorCommand::class)
                            ->execute()
                    )
                );
                $response->send();
        }
    }

}