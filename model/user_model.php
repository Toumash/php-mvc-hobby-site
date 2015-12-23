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
        //FIXME: database users  @@@CRITICAL@@@
        if ($login == 'toumash' && $password == 'xpenetrator') {
            $user = new User(0, 'toumash', 'Tomasz Dluski');

            $_SESSION[self::USER_KEY] = $user;
            return $user;
        } else {
            $hash = '';
            if (true /* login exists in database)*/) {
                // get hash from database
            } else {
                $hash = password_hash("SDgsgsfh", PASSWORD_DEFAULT);
                // to prevent timing attacks
            }
            if (password_verify($password, $hash)) {
                $id = 4; // fetch from db
                $name = 'kowalski'; //fetched from db
                return new User($id, $login, $name);
            }
            return null;
        }
    }

    public function logOut()
    {
        $_SESSION[self::USER_KEY] = null;
        session_destroy();
    }

    public function loginExists($login)
    {
        // TODO: database lookup
        return false;
    }

    public function register($login, $password, $email)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // TODO: save hash and login with email
        // TODO: registration
        return true;
    }

    public function getLoggedUser()
    {
        return $_SESSION[self::USER_KEY];
    }
}