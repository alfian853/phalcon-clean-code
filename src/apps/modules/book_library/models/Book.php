<?php
namespace App\BookLibrary\Models;

use App\Library\Orm\BaseModel;



class Book extends BaseModel
{
    public function initialize()
    {
        $this->setSource('books');
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}