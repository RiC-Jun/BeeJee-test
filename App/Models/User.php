<?php

namespace App\Models;

use App\Db;

class User
{
    const TABLE = 'users';

    protected $id;
    protected $login;
    public $password;

    public static function getPasswordHashByLogin($login)
    {
        $db = new Db();

        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE login=:login';
        $data = $db->query(
            $sql,
            [':login' => $login],
            static::class
        );

        return $data ? $data[0] : null;
    }

    public function logIn()
    {
        setcookie('logged', '1', time()+13600, '/');
    }

    public function logOut()
    {
        setcookie('logged', '', time() - 9000, '/');
    }

    public static function isLoggedIn()
    {
        return $_COOKIE['logged'] ?: null;
    }
}