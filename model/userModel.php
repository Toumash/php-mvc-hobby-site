<?php

require_once ROOT . '/model/object/User.php';
require_once ROOT . '/model/interface/UserModelInterface.php';
require_once ROOT . '/model/DatabaseModel.php';

class UserModel extends DatabaseModel implements UserModelInterface
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
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $users = $this->db->selectCollection('users');
        $usr = $users->findOne(['login' => (string)$login, 'password' => (string)$hash]);
        if ($usr) {
            $_SESSION[self::USER_KEY] = new User($usr['_id'], $usr['login'], $usr['email']);
            return true;
        }
        return false;
    }

    public function logOut()
    {
        $_SESSION[self::USER_KEY] = null;
        session_destroy();
        session_unset();
    }

    public function register($login, $password, $email)
    {
        if ($this->loginExists($login)) {
            return false;
        }
        if ($this->emailExists($email)) {
            return false;
        }
        $users = $this->db->selectCollection('users');
        $obj = [
            'login' => (string)$login,
            'password' => (string)$password,
            'email' => (string)$email
        ];
        $users->insert($obj);
        return true;
    }

    public function loginExists($login)
    {
        $users = $this->db->selectCollection('users');
        if ($users->findOne(['login' => (string)$login])) {
            return true;
        }
        return false;
    }

    public function emailExists($email)
    {
        $users = $this->db->selectCollection('users');
        if ($users->findOne(['email' => (string)$email])) {
            return true;
        }
        return false;
    }

    public function getLoggedUser()
    {
        return $_SESSION[self::USER_KEY];
    }
}