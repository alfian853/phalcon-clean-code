<?php

namespace Core\Library\DataTables;


class Criteria
{
    public $modelClass;
    public $page,$length;
    public $orderBy,$orderDir;
    public $search_list = [];
    public $response_list = [];
}