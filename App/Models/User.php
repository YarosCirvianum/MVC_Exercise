<?php

namespace App\Models;

use App\Models\Orm;

class User extends Orm
{
    private $userLogged=[];

    public function __construct() {
        parent::__construct('users');

    }
    public function login($username,$password) {
        foreach ($_SESSION[$this->model] as $user) {
            if ($user['username']==$username) {
                if ($user['password']==$password) {
                    return $user;
                }
            }
        }
        return 3;
    }

    public function checkPassword($p) {
        $regex="";
        if (preg_match($regex,$p)) {
            return true;
        }
        return false;
    }

    public function getUserLogged()  {
        if ($_SESSION['user_logged'])
        return $_SESSION['user_logged'];
    }

    public function setUserLogged($user) {
        $_SESSION['user_logged'] = $user;
        $this->userLogged=$user;
    }
}
