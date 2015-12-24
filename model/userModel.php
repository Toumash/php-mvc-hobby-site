<?php

require_once ROOT.'/model/object/User.php';
require_once ROOT.'/model/interface/UserModelInterface.php';
require_once ROOT . '/model/DatabaseModel.php';

class UserModel extends Database implements UserModelInterface
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
        //TODO: logic
    }

    public function logOut()
    {
        $_SESSION[self::USER_KEY] = null;
        session_destroy();
        session_unset();
    }

    public function loginExists($login)
    {
        //TODO: logic
    }

    public function register($login, $password, $email)
    {
        // TODO: logic
    }

    public function getLoggedUser()
    {
        return $_SESSION[self::USER_KEY];
    }
}