<?php

class userModel extends databaseModel
{
    const USER_KEY = 'user';

    public function isLoggedIn()
    {
        if (isset($_SESSION[self::USER_KEY])) {
            return true;
        } else {
            return false;
        }
    }

    public function logIn($login, $password)
    {
        //FIXME: not database users  @@@CRITICAL@@@
        if ($login == 'toumash' && $password == 'xpenetrator') {
            $user = new User(0, 'toumash','Tomasz Dluski');


            $_SESSION[self::USER_KEY] = $user;
            return $user;
        } else {
            return false;
        }
    }

    public function logOut()
    {
        $_SESSION[self::USER_KEY] = null;
    }

    public function register($login, $password, $email)
    {
        // TODO: registration
        return true;
    }

    public function getLoggedUser(){
        return $_SESSION[self::USER_KEY];
    }
}