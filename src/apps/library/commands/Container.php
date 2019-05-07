<?php

namespace App\Library\Commands;


interface Container
{
    /**
     * Return a new instance of an object
     *
     * @param string $class
     * @return mixed
     */
    public function add($class);

    /**
     * @param $class
     * @return Command
     */
    public function get($class);

}