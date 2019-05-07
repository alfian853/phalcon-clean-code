<?php

namespace App\Oauth\Controllers\Common;

use Phalcon\Mvc\Controller;

class ErrorController extends Controller
{
    public function notFoundAction()
    {
        return "Not Found";
    }
}