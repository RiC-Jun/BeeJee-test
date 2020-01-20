<?php

namespace App\Controllers;

use App\Models\User;

class Task extends ControllerViewableAbstract
{
    protected function handle()
    {
        if (!User::isLoggedIn()) {
            $_SESSION['message'] = 'Авторизуйтесь для изменения задач!';
            header('Location: /login/'); exit;
        }
        $this->view->message = $_SESSION['message'];
        unset($_SESSION['message']);
        $this->view->task = \App\Models\Task::getTaskById($_GET['id']);
        echo $this->view->render(__DIR__ . '/../../templates/task.php');
    }
}