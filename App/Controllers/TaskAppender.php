<?php

namespace App\Controllers;

use App\Models\Task;

class TaskAppender extends ControllerAbstract
{
    protected $task;

    public function __construct()
    {
        $this->task = new Task();
        $this->task->username = $_POST['username'];
        $this->task->email = $_POST['email'];
        $this->task->description = htmlspecialchars($_POST['description']);
    }

    protected function handle()
    {
        if($this->task->insertTask()) {
            $_SESSION['message'] = 'Новая задача успешно добавлена!';
        } else {
            $_SESSION['message'] = 'Проблема с добавлением новой задачи!';
        }
        header('Location: /');
    }

}