<?php
namespace App\BookLibrary\Repositories;

use App\BookLibrary\Models\Author;
use App\Library\Orm\AbstractRepository;

class AuthorRepository extends AbstractRepository
{

    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return Author::class;
    }
}