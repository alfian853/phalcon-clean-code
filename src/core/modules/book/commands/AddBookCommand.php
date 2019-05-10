<?php

namespace Core\Modules\Book\Commands;

use Core\Modules\Book\Requests\AddBookRequest;
use Core\Library\Commands\CommandInterface;
use Core\Library\Repositories\RepositoryInterface;

class AddBookCommand implements CommandInterface
{
    private $bookRepository;

    /**
     * AddBookCommand constructor.
     * @param RepositoryInterface $bookRepository
     */
    public function __construct(RepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param AddBookRequest $request
     * @return bool
     */
    public function execute($request = null)
    {
        return $this->bookRepository->create([
            'title' => $request->getTitle(),
            'isbn' => $request->getIsbn(),
            'author_id' => $request->getAuthorId()
        ]) != null;
    }
}