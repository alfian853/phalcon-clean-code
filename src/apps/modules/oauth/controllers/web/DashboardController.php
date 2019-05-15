<?php

namespace App\Oauth\Controllers\Web;

use Phalcon\Mvc\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->view->pick('table.volt/index');
    }


    public function helloAction(){
        return "hell yeah!";
    }
}