<?php

namespace Core\Library\Commands;

class CommandContainer {

    private $container;

    public function __construct()
    {
        $this->container = [];
    }

    /**
     * Return a new instance of an object
     *
     * @param CommandInterface $command
     * @return mixed
     */
    public function add($command)
    {
        // TODO: Implement add() method.
//        $this->container[$class] = new $class;
        $this->container[get_class($command)] = $command;

    }

    /**
     * @param $class
     * @return CommandInterface
     */
    public function get($class)
    {
        // TODO: Implement get() method.
        return $this->container[$class];
    }
}