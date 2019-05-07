<?php

namespace App\BookLibrary\Commands;
use App\Library\Commands\Command;

class AddBookCommand implements Command
{

    /**
     * @param \Phalcon\Http\Request $request
     */
    public function execute($request)
    {
        var_dump('addBookCommand');
        var_dump($request->get('user_id'));
        die();
    }
}