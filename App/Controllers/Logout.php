<?php

namespace App\Controllers;

use App\Models\User;

class Logout
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
        $this->user->logOut();
        header('Location: /');
    }
}