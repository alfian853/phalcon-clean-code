<?php

namespace App\Library\Commands;

class CommandContainer implements Container{

    private $container;

    public function __construct()
    {
        $this->container = [];
    }

    /**
     * Return a new instance of an object
     *
     * @param string $class
     * @return mixed
     */
    public function add($class)
    {
        // TODO: Implement add() method.
        $this->container[$class] = new $class;
    }

    /**
     * @param $class
     * @return Command
     */
    public function get($class)
    {
        // TODO: Implement get() method.
        return $this->container[$class];
    }
}