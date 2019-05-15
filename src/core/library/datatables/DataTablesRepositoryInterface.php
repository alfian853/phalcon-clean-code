<?php

namespace Core\Library\DataTables;


interface DataTablesRepositoryInterface
{
    function findByDataTablesRequest(Criteria $request);
}