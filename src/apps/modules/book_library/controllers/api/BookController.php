<?php
namespace App\BookLibrary\Controllers\Api;

use App\BookLibrary\Commands\AddBookCommand;
use App\BookLibrary\Commands\GetBookCommand;
use App\BookLibrary\Request\AddBookRequest;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class BookController
 * @property \App\Library\Commands\Container commands injected into DI
 */
class BookController extends Controller
{

    public function indexAction() {
        $request = $this->request;
        $response = $this->response;
        $response->setContentType('application/json');

        switch ($request->getMethod()){
            case 'POST':
                $jsonBody = $request->getJsonRawBody();
                $addBookReq = new AddBookRequest();
                $addBookReq->setAuthorId($jsonBody->author_id);
                $addBookReq->setIsbn($jsonBody->isbn);
                $addBookReq->setTitle($jsonBody->title);
                $response->setContent(json_encode([
                        'success' => $this->commands->get(AddBookCommand::class)
                            ->execute($addBookReq)
                    ])
                );
                $response->send();
                break;
            case 'GET':
                $response->setContent(
                    json_encode(
                        $this->commands->get(GetBookCommand::class)
                            ->execute()
                    )
                );
                $response->send();
        }
    }


}