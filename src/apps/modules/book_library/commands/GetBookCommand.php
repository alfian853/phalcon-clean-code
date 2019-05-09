<?php

namespace App\BookLibrary\Commands;


use App\Library\Commands\CommandInterface;
use App\Library\Orm\RepositoryInterface;

class GetBookCommand implements CommandInterface {

    private $bookRepository;

    /**
     * GetBookCommand constructor.
     * @param RepositoryInterface $bookRepository
     */
    public function __construct(RepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }


    /**
     * @param null $request
     * @return array
     */
    public function execute($request = null)
    {
        return $this->bookRepository->all()->toArray();
    }
}