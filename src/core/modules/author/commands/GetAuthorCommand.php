<?php

namespace Core\Modules\Author\Commands;

use Core\Library\Commands\CommandInterface;
use Core\Library\Repositories\RepositoryInterface;

class GetAuthorCommand implements CommandInterface
{

    private $authorRepository;

    /**
     * GetAuthorCommand constructor.
     * @param RepositoryInterface $authorRepository
     */
    public function __construct(RepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }


    /**
     * @param null $request
     * @return array
     */
    public function execute($request = null)
    {
        return $this->authorRepository->all()->toArray();
    }
}