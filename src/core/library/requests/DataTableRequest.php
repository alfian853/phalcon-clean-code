<?php
namespace Core\Library\Requests;


class DataTableRequest
{
    protected $draw,$orderBy,$orderDir,$columns = [],$start,$length;

    /**
     * @return mixed
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @param mixed $draw
     */
    public function setDraw(int $draw)
    {
        $this->draw = $draw;
    }


    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart(int $start)
    {
        $this->start = $start;
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
    public function getOrderDir() : string
    {
        return $this->orderDir;
    }

    /**
     * @param mixed $orderDir
     */
    public function setOrderDir(string $orderDir)
    {
        $this->orderDir = $orderDir;
    }

    public function addColumn(string $name,string $searchValue,bool $searchable){

        array_push($this->columns,[
            'name' => $name,
            'search' => $searchValue,
            'searchable' => $searchable
        ]);
    }

    /**
     * @return mixed
     */
    public function getOrderBy() : string
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     */
    public function setOrderBy(string $orderBy)
    {
        $this->orderBy = $orderBy;
    }



}