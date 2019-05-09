<?php

namespace App\BookLibrary\Models;


use App\Library\Orm\BaseModel;

/**
 * @property int id
 * @property string name
 * @property string email
 */

class Author extends BaseModel
{
    public function initialize()
    {
        $this->setSource('authors');
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}