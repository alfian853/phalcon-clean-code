<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/17/19
 * Time: 4:59 AM
 */

namespace Core\Library\Requests;


class SearchRequest
{
    private $page,$length,$search;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage(int $page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength(int $length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $search
     */
    public function setSearch(string $search)
    {
        $this->search = $search;
    }


}