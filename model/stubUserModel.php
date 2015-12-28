<?php

require_once ROOT . '/model/object/User.php';
require_once ROOT . '/model/interface/UserModelInterface.php';

class stubUserModel extends DatabaseModel implements UserModelInterface
{
    const USER_KEY = 'user';
    private $session = array();
    /**
     * @var array
     */
    private $users = array();

    public function __construct()
    {
        $this->users = ['touamsh' => [new User(0, 'toumash', 'tomash@gmail.com'), 'admin2'],
            'admin' => [new User(1, 'admin', 'admin@wai.pl'), 'admin1']];
    }

    public function isLoggedIn()
    {
        if (isset($this->session[self::USER_KEY])) {
            return true;
        } else {
            return false;
        }
    }

    public function logIn($login, $password)
    {
        if ($this->users[$login][1] == $password) {
            $user = $this->users[$login][0];
            $this->session[self::USER_KEY] = $user;
            return $user;
        }
        return false;
    }

    public function logOut()
    {
        $this->session[self::USER_KEY] = null;
        unset($this->session);
    }

    public function loginExists($login)
    {
        return isset($this->users[$login]);
    }

    public function register($login, $password, $email)
    {
        $this->users[$login] = [new User(uniqid(), $login, $email), $password];
        return true;
    }

    public function getLoggedUser()
    {
        return $this->session[self::USER_KEY];
    }

    function emailExists($email)
    {
        foreach ($this->users as $login => $user) {
            if ($user[0]->email == $email) {
                return true;
            }
        }
        return false;
    }
}