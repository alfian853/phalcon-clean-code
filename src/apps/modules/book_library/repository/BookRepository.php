<?php
namespace App\BookLibrary\Repositories;

use App\BookLibrary\Models\Book;
use App\Library\Orm\AbstractRepository;

class BookRepository extends AbstractRepository
{

    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return Book::class;
    }
}