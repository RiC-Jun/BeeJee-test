<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;

class TaskUpdater extends ControllerAbstract
{
    protected $task;
    protected $id;
    protected $description;
    protected $checked;
    protected $message;

    public function __construct()
    {
        if (!User::isLoggedIn()) {
            $_SESSION['message'] = 'Авторизуйтесь для изменения задач!';
            header('Location: /login/'); exit;
        }
        $this->description = htmlspecialchars($_POST['description']);
        $this->checked = $_POST['checked'] ? 1 : 0;
        $this->id = $_POST['id'];
    }

    protected function handle()
    {
        $this->task = Task::getTaskById($_POST['id']);
        $this->isDescriptionChanged();
        $this->isStatusChanged();
        $result = $this->task->updateTask();

        if ($this->message && $result) {
            $_SESSION['message'] = $this->message;
        }

        header('Location: /task/?id=' . $this->id);
    }

    protected function isDescriptionChanged()
    {
        if ($this->task->description != $this->description) {
            $this->task->description = $this->description;
            $this->task->edited = 1;
            $this->message = 'Задача отредактирована. ';
        }
    }

    protected function isStatusChanged()
    {
        if ($this->task->checked != $this->checked) {
            $this->task->checked = $this->checked;
            if ($this->message) {
                $this->message .= 'Статус задания изменен.';
            } else {
                $this->message = 'Статус задания изменен.';
            }
        }
    }

}