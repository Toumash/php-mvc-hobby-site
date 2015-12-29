<?php

class User
{
    public $_id;
    public $login;
    public $email;

    public function __construct($_id, $login, $email)
    {
        $this->_id = $_id;
        $this->login = $login;
        $this->email = $email;
    }

    public static function anonymous()
    {
        return new User(-1, 'niezalogowany', 'brak');
    }
}