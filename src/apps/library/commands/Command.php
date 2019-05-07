<?php
namespace App\Library\Commands;


interface Command
{
    public function execute($request);
}