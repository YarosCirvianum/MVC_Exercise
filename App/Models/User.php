<?php

namespace App\Models;

use App\Models\Orm;

class User extends Orm
{


    public function __construct() {
        parent::__construct('users');
    }

    public function login($username, $password) {
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

    public function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserLogged()
    {
        if (isset($_SESSION['user_logged'])) {
            return $_SESSION['user_logged'];
        }
        return null;
    }

    public function setUserLogged($user)
    {
        //si passem null elimina el user_looged = logout
        if ($user == null) {
            unset($_SESSION['user_logged']);
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

    public function generateToken() {
        $caracters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // str_shuffle barrejem tot i amb substr agafem els 12 primers de la barreja.
        $token = substr( str_shuffle($caracters), 0, 12);
        return $token;
    }

    public function userVerified($user) {
        if ($user['verified'] == true) {
            return true;
        }
        return false;
    }
}
