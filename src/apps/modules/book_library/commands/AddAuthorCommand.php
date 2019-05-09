<?php

namespace App\BookLibrary\Commands;

use App\BookLibrary\Request\AddAuthorRequest;
use App\Library\Commands\CommandInterface;
use App\Library\Orm\RepositoryInterface;

class AddAuthorCommand implements CommandInterface {

    private $authorRepository;

    /**
     * AddAuthorCommand constructor.
     * @param RepositoryInterface $authorRepository
     */
    public function __construct(RepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param AddAuthorRequest $request
     * @return bool
     */
    public function execute($request = null)
    {
        return $this->authorRepository->create([
            'name' => $request->getName(),
            'email' => $request->getEmail()
        ]) != null;
    }
}