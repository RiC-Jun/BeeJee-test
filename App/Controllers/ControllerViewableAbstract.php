<?php

namespace App\Controllers;

use App\Views\View;

abstract class ControllerViewableAbstract extends ControllerAbstract
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
        $this->view->cssPath = (include __DIR__ . '/../config.php')['paths']['css'];
        $this->view->css = ['bootstrap.min.css', 'style.css'];
    }

    protected function handle() {}

}