<?php

namespace Core\Modules\Author\Commands;

use Core\Modules\Author\Requests\AddAuthorRequest;
use Core\Library\Commands\CommandInterface;
use Core\Library\DataTables\RepositoryInterface;

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