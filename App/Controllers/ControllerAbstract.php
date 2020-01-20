<?php

namespace App\Controllers;

abstract class ControllerAbstract
{

    public function __invoke()
    {
        $this->handle();
    }

    abstract protected function handle();
}