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
}