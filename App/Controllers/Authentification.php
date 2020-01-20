<?php

namespace App\Controllers;

use App\Models\User;

class Authentification extends ControllerAbstract
{
    protected $user;
    protected $login;
    protected $password;

    public function __construct()
    {
        $this->login = $_POST['login'];
        $this->password = strip_tags(trim($_POST['password']));
    }

    protected function handle()
    {
        $this->user = User::getPasswordHashByLogin($this->login);

        if (password_verify($this->password, $this->user->password)) {
            $this->user->logIn();
            $_SESSION['message'] = 'Авторизация успешна!';
            header('Location: /');
        } else {
            $_SESSION['message'] = 'Пароль и логин неверны!';
            header('Location: /login/');
        }
    }
}