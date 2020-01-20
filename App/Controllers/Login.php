<?php

namespace App\Controllers;

use App\Models\User;

class Login extends ControllerViewableAbstract
{
    protected function handle()
    {
        $this->view->message = $_SESSION['message'];
        unset($_SESSION['message']);
        $this->view->admin = User::isLoggedIn();
        echo $this->view->render(__DIR__ . '/../../templates/login.php');
    }
}