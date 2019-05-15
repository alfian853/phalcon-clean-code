<?php

namespace Core\Library\DataTables;


class SearchCriteria
{
    public $field;
    public $data;

    /**
     * SearchCriteria constructor.
     * @param $field
     * @param $data
     */
    public function __construct($field, $data)
    {
        $this->field = $field;
        $this->data = $data;
    }


}