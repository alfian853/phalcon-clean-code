<?php
namespace Core\Library\Commands;

interface CommandInterface
{
    public function execute(CommandRequest $request = null);
}