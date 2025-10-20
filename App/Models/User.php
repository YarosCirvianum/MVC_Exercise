<?php

namespace App\Models;

use App\Models\Orm;

class User extends Orm
{


    public function __construct()
    {
        parent::__construct('users');
    }

    public function login($username, $password)
    {
        foreach ($_SESSION[$this->model] as $user) {
            if ($user['username'] == $username) {
                if ($user['password'] == $password) {
                    return $user;
                }
            }
        }
        return null;
    }

    public function checkPassword($p)
    {
        $regex = "/^[0-9]+$/"; //regex de només numeros
        if (preg_match($regex, $p)) {
            return true;
        }
        return false;
    }

    public function checkUsername($u)
    {
        $regex = "/^[a-z]+$/"; //regex de només minuscules
        if (preg_match($regex, $u)) {
            return true;
        }
        return false;
    }

    public function getUserLogged()
    {
        if (isset($_SESSION['user_logged'])) {
            return $_SESSION['user_logged'];
        }
    }

    public function setUserLogged($user)
    {
        //si passem null elimina el user_looged = logout
        if ($user == null) {
            unset($_SESSION['user_looged']);
        } else {
            $_SESSION['user_logged'] = $user;
        }
    }

    public function usernameExist($username) {
        foreach ($_SESSION[$this->model] as $user) {
            if ($username == $user['username']) {
                return true;
            } 
        }
        return false;
    }
}
