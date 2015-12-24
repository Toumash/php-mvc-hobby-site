<?php

class User
{
    public $id;
    public $login;
    public $email;

    public function __construct($id, $login, $email)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
    }

    public static function anonymous()
    {
        return new User(-1, 'niezalogowany', 'brak');
    }
}