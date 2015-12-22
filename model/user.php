<?php

class User
{
    public $id;
    public $login;
    public $name;

    public function __construct($id, $login, $name)
    {
        $this->id = $id;
        $this->login = $login;
        $this->name = $name;
    }

    public static function createAnonymous($name)
    {
        return new User(-1, 'Niezalogowany', $name);
    }

    public function isRegistered()
    {
        return $this->id != -1;
    }
}