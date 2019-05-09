<?php
namespace App\Library\Commands;

interface CommandInterface
{
    public function execute($request = null);
}